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

namespace app\modules\invoice\controllers;

################################################################################
# Use(s)                                                                       #
################################################################################

use app\controllers\IdbBillingController;
use idbyii2\models\data\IdbillInvoiceDataProvider;
use idbyii2\models\data\IdbillPackageDataProvider;
use idbyii2\models\idb\BillingIdbBillingClient;
use kartik\mpdf\Pdf;
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

        $this->dataProvider = new IdbillInvoiceDataProvider();
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
        return parent::actionRenderIndex('Invoices', $this->dataProvider);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DynamicModel(
            [
                'payment_id',
                'invoice_data',
                'invoice_number',
                'amount',
            ]
        );

        if (Yii::$app->request->isPost && array_key_exists('DynamicModel', Yii::$app->request->post())) {
            $response = $this->model->createInvoice(json_encode(Yii::$app->request->post('DynamicModel')));

            if ($response !== null) {
                return $this->redirect(['index']);
            }
        }

        return $this->render(
            'create',
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
            $this->model->deleteActionCost($id);

            return $this->redirect(['index']);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionShow($id)
    {
        $model = BillingIdbBillingClient::model();

        $exp = [
            'o' => '=',
            'l' => '#col',
            'r' => ':col'
        ];

        $invoice = $model->findInvoices($exp, ['#col' => 'id'], [':col' => $id])['QueryData'];
        $invoice = $invoice[0];

        $content = $this->renderPartial(
            '@idbyii2/static/templates/PDFs/invoice',
            compact('invoice')
        );


        $pdf = new Pdf(
            [
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'content' => $content,
                // format content from your own css file if needed or use the
                // set mPDF properties on the fly
                'options' => ['title' => 'IDBank invoice'],
            ]
        );

        return $pdf->render();
    }
}

################################################################################
#                                End of file                                   #
################################################################################
