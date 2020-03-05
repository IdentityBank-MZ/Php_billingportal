<?php
# * ********************************************************************* *
# *                                                                       *
# *   Billing Portal                                                      *
# *   This file is part of billingportal. This project may be found at:   *
# *   https://github.com/IdentityBank/Php_billingportal.                  *
# *                                                                       *
# *   Copyright (C) 2020 by Identity Bank. All Rights Reserved.           *
# *   https://www.identitybank.eu - You belong to you                     *
# *                                                                       *
# *   This program is free software: you can redistribute it and/or       *
# *   modify it under the terms of the GNU Affero General Public          *
# *   License as published by the Free Software Foundation, either        *
# *   version 3 of the License, or (at your option) any later version.    *
# *                                                                       *
# *   This program is distributed in the hope that it will be useful,     *
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of      *
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the        *
# *   GNU Affero General Public License for more details.                 *
# *                                                                       *
# *   You should have received a copy of the GNU Affero General Public    *
# *   License along with this program. If not, see                        *
# *   https://www.gnu.org/licenses/.                                      *
# *                                                                       *
# * ********************************************************************* *

################################################################################
# Namespace                                                                    #
################################################################################

namespace app\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################

use app\helpers\BillingConfig;
use app\helpers\Translate;
use app\models\IdbBillingLoginForm;
use Exception;
use idbyii2\components\PortalApi;
use idbyii2\helpers\IdbMfaHelper;
use idbyii2\helpers\IdbPortalApiActions;
use idbyii2\helpers\IdbSecurity;
use idbyii2\helpers\IdbYii2Login;
use idbyii2\helpers\Localization;
use idbyii2\helpers\Totp;
use idbyii2\models\db\BillingAuthlog;
use idbyii2\models\db\BillingUserData;
use idbyii2\models\identity\IdbBillingUser;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends IdbController
{

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param null $idbjwt
     *
     * @return mixed
     */
    public function actionIdbLogin($idbjwt = null)
    {
        return IdbYii2Login::idbLogin($idbjwt, 'billing', $this, new IdbBillingLoginForm());
    }

    /**
     * @param null $post
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionLogin($post = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new IdbBillingLoginForm();
        if (empty($post)) {
            $post = Yii::$app->request->post();
        }
        if ($model->load($post) && $model->login()) {
            BillingAuthlog::login(Yii::$app->user->id);
            if (!empty(Yii::$app->user->getReturnUrl())) {
                if (!empty($post['jwt']) && $post['jwt']) {
                    return $this->goHome();
                } else {
                    $this->redirect(Yii::$app->user->getReturnUrl());
                }
                Yii::$app->end();
            }

            return $this->goHome();
        } else {
            $userId = trim($model->userId);
            $accountNumber = trim($model->accountNumber);
            $login = IdbBillingUser::createLogin($userId, $accountNumber);
            $userAccount = IdbBillingUser::findUserAccountByLogin($login);
            if ($userAccount) {
                BillingAuthlog::error($userAccount->uid, ['p' => strlen($model->accountPassword) . "_" . time()]);
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return void
     */
    public function actionProfile()
    {
        $this->redirect(Url::to(['/idbuser/profile']));
    }

    /**
     * @param null $post
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionMfa()
    {
        $this->layout = 'fullscreen';
        $model = ['code', 'code_next', 'mfa'];
        $model = new DynamicModel($model);
        $post = Yii::$app->request->post();

        if (empty(Yii::$app->user->identity->mfa)) {
            $model->addRule(['code', 'code_next'], 'required')
                  ->addRule(['code', 'code_next'], 'string', ['max' => 16])
                  ->addRule(
                      'code',
                      'compare',
                      [
                          'compareAttribute' => 'code_next',
                          'operator' => '!==',
                          'message' => Translate::_('billing', "Provide two consecutive authentication codes.")
                      ]
                  )
                  ->addRule(['mfa'], 'string', ['max' => 128]);

            if (
                !empty($post)
                && $model->load($post)
                && !empty($model->mfa)
                && !empty($model->code)
                && !empty($model->code_next)
                && ($model->code !== $model->code_next)
            ) {
                $model->code = preg_replace('/\s+/', "", $model->code);
                $model->code_next = preg_replace('/\s+/', "", $model->code_next);

                if (
                    Totp::verify($model->mfa, $model->code)
                    && Totp::verify($model->mfa, $model->code_next)
                    && ($model->code !== $model->code_next)
                ) {
                    $modelData = BillingUserData::instantiate(
                        [
                            'uid' => Yii::$app->user->identity->id,
                            'key' => 'mfa',
                            'value' => json_encode(['type' => 'totp', 'value' => $model->mfa])
                        ]
                    );
                    if (
                        $modelData->save()
                        && Yii::$app->user->identity->validateMfa($model)
                    ) {
                        return $this->goHome();
                    }
                } else {
                    $errorMsg = Translate::_('billing', 'Invalid code');
                    $model->addError('code', $errorMsg);
                    $model->addError('code_next', $errorMsg);
                }
            } else {
                $model->mfa = Yii::$app->user->identity->generateMfaSecurityKey();
            }

            return $this->render(
                'createMfa',
                ArrayHelper::merge(['model' => $model], IdbMfaHelper::getMfaViewVariables($model, BillingConfig::get()))
            );
        } else {
            $model->addRule(['code'], 'required')
                  ->addRule('code', 'string', ['max' => 16]);

            if (!empty($post)
            ) {
                if (
                    $model->load($post)
                    && Yii::$app->user->identity->validateMfa($model)
                ) {
                    if (!empty(Yii::$app->user->getReturnUrl())) {
                        $this->redirect(Yii::$app->user->getReturnUrl());
                        Yii::$app->end();
                    }

                    return $this->goHome();
                } else {
                    $this->actionLogout();
                }
            } else {
                if (Yii::$app->user->identity->validateMfa()) {
                    return $this->goHome();
                }
            }

            return $this->render('mfa', ['model' => $model]);
        }
    }

    /**
     * @return mixed
     */
    public function actionLogout()
    {
        BillingAuthlog::logout(Yii::$app->user->id);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return array|false|string|null
     * @throws \yii\base\ExitException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIdbApi()
    {
        $portalBusinessApi = PortalApi::getBusinessApi();

        return IdbPortalApiActions::execute($portalBusinessApi, apache_request_headers(), $_REQUEST);
        Yii::$app->end();
    }
}

################################################################################
#                                End of file                                   #
################################################################################
