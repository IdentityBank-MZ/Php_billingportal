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

namespace app\modules\package\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################

use app\controllers\IdbBillingController;
use app\helpers\Translate;
use idbyii2\models\data\IdbillPackageDataProvider;
use idbyii2\models\idb\BillingIdbBillingClient;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;

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
     * @return bool|Response
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $return = parent::beforeAction($action);
        if (!$return) {
            return $return;
        }

        $this->dataProvider = new IdbillPackageDataProvider();
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
        return parent::actionRenderIndex('Packages', $this->dataProvider);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $this->view->title = "Add";

        $model = new DynamicModel(
            [
                'order',
                'credits',
                'duration',
                'name',
                'price',
                'currency',
                'image',
                'included',
                'excluded',
                'tag',
                'active'
            ]
        );

        if (Yii::$app->request->isPost && array_key_exists('DynamicModel', Yii::$app->request->post())) {
            $response = $this->model->createPackage(Yii::$app->request->post('DynamicModel'));

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
     * @return string|Response getCountAllPackages
     */
    public function actionEdit($id)
    {
        $packages = $this->model->getCountAllPackages()['QueryData'];
        $packageId = null;
        $this->view->title = "Edit";

        if (!is_null($packages)) {
            foreach ($packages as $key => $package) {
                if ($package[0] == $id) {
                    $packageId = $key;
                }
            }
        }

        $model = new DynamicModel(
            [
                'order' => $packages[$packageId][1],
                'credits' => $packages[$packageId][2],
                'duration' => $packages[$packageId][3],
                'name' => $packages[$packageId][4],
                'price' => $packages[$packageId][5],
                'currency' => $packages[$packageId][6],
                'image' => $packages[$packageId][7],
                'included' => $packages[$packageId][8],
                'excluded' => $packages[$packageId][9],
                'tag' => $packages[$packageId][10],
                'active' => $packages[$packageId][11]
            ]
        );

        if (Yii::$app->request->isPost && array_key_exists('DynamicModel', Yii::$app->request->post())) {
            $response = $this->model->editPackage(intval($id), Yii::$app->request->post('DynamicModel'));

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
     * @return Response
     */
    public function actionDelete($id)
    {
        if (!is_null($id)) {
            $response = $this->model->getBusinessPackageByPackage($id);

            $usesCount = ArrayHelper::getValue($response, 'CountAll.0.0', -1);

            if ($usesCount === 0) {
                $this->model->deletePackage(intval($id));
            } elseif ($usesCount === -1) {
                Yii::$app->session->setFlash('dangerMessage', Translate::_('billing', 'Something goes wrong'));
            } else {
                Yii::$app->session->setFlash('dangerMessage', Translate::_('billing', 'You can\'t delete package used by businesses'));
            }

            return $this->redirect(['index']);
        }
    }
}

################################################################################
#                                End of file                                   #
################################################################################
