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

namespace app\modules\credit\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################

use app\controllers\IdbBillingController;
use idbyii2\models\data\IdbillCreditDataProvider;
use idbyii2\models\data\IdbillPackageDataProvider;
use idbyii2\models\idb\BillingIdbBillingClient;
use Yii;
use yii\base\DynamicModel;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Default controller for the `package` module
 */
class DefaultController extends IdbBillingController
{

    /** @var IdbillPackageDataProvider */
    private $dataProvider;
    private $model;

    /**
     * @param $action
     *
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $return = parent::beforeAction($action);
        if (!$return) {
            return $return;
        }

        $this->dataProvider = new IdbillCreditDataProvider();
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
        return parent::actionRenderIndex('Credits', $this->dataProvider);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->view->title = "Add";

        $model = new DynamicModel(
            [
                'credits',
                'action_name',
                'action_type'
            ]
        );

        if (Yii::$app->request->isPost && array_key_exists('DynamicModel', Yii::$app->request->post())) {
            $response = $this->model->addActionCost(Yii::$app->request->post('DynamicModel'));

            if ($response !== null) {
                return $this->redirect(['index']);
            }
        }

        return $this->render(
            'form',
            [
                'model' => $model
            ]
        );
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        $exp = [
            'o' => '=',
            'l' => '#col',
            'r' => ':col'
        ];
        $packages = $this->model->findCountAllActionsCosts($exp, ['#col' => 'id'], [':col' => $id])['QueryData'];

        $this->view->title = "Edit";

        if (!empty($packages[0])) {
            $model = new DynamicModel(
                [
                    'credits' => empty($packages[0][1]) ? null : $packages[0][1],
                    'action_name' => empty($packages[0][3]) ? null : $packages[0][3],
                    'action_type' => empty($packages[0][2]) ? null : $packages[0][2]
                ]
            );
        } else {
            return $this->redirect('index');
        }

        if (Yii::$app->request->isPost && array_key_exists('DynamicModel', Yii::$app->request->post())) {
            $response = $this->model->editActionCost(intval($id), Yii::$app->request->post('DynamicModel'));

            if ($response !== null) {
                return $this->redirect(['index']);
            }
        }

        return $this->render(
            'form',
            [
                'model' => $model
            ]
        );
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        if (!is_null($id)) {
            $this->model->deleteActionCost(intval($id));

            return $this->redirect(['index']);
        }
    }

}

################################################################################
#                                End of file                                   #
################################################################################
