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

namespace app\modules\business\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################


use app\controllers\IdbBillingController;
use app\helpers\Translate;
use idbyii2\components\PortalApi;
use idbyii2\enums\EmailActionType;
use idbyii2\helpers\EmailTemplate;
use idbyii2\models\data\IdbillBusinessDataProvider;
use idbyii2\models\idb\BillingIdbBillingClient;
use Yii;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Default controller for the `package` module
 */
class DefaultController extends IdbBillingController
{

    /** @var IdbillBusinessDataProvider */
    private $dataProvider;
    private $model;

    /**
     * @param $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $return = parent::beforeAction($action);
        if (!$return) {
            return $return;
        }

        $this->dataProvider = new IdbillBusinessDataProvider();
        $this->dataProvider->init();

        $this->model = BillingIdbBillingClient::model();


        return $return;
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        return parent::actionRenderIndex('Businesses', $this->dataProvider);
    }

    /**
     * @param $oid
     *
     * @return \yii\web\Response
     */
    public function actionSendPaymentRequest($oid)
    {
        $portalBusinessApi = PortalApi::getBusinessApi();

        $email = $portalBusinessApi->requestOrganizationEmails(['oid' => $oid]);

        if ($email !== -1) {
            if (
                EmailTemplate::sendEmailByAction(
                    EmailActionType::BILLING_PAYMENT_REMINDER,
                    ['firstName' => '', 'lastName' => '', 'businessName' => ''],
                    Translate::_('billing', 'Identity Bank payment reminder.'),
                    $email,
                    Yii::$app->language
                )
            ) {
                Yii::$app->session->setFlash(
                    'success',
                    Translate::_('billing', 'Your email was sent successfully.')
                );
            };
        }

        if (!Yii::$app->session->has('success')) {
            Yii::$app->session->setFlash(
                'error',
                Translate::_('billing', 'Your email wasn\'t sent successfully.')
            );
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}

################################################################################
#                                End of file                                   #
################################################################################
