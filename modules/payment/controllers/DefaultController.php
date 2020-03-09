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

namespace app\modules\payment\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################

use app\controllers\IdbBillingController;
use idbyii2\models\data\IdbillPackageDataProvider;
use idbyii2\models\data\IdbillPaymentDataProvider;
use idbyii2\models\idb\BillingIdbBillingClient;

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

        $this->dataProvider = new IdbillPaymentDataProvider(['timestamp' => 'desc']);
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
        return parent::actionRenderIndex('Payments', $this->dataProvider);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        if (!is_null($id)) {
            $this->model->deleteActionCost($id);

            return $this->redirect(['index']);
        }
    }
}

################################################################################
#                                End of file                                   #
################################################################################
