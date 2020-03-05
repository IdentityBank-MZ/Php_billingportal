<?php

use app\helpers\Translate;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top: 100px">
    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-8" style="margin-left: 30px; margin-top: 30px">
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <h2><?= Translate::_('billing', Html::encode($this->title)) ?></h2>

                                <?php Pjax::begin(); ?>
                                <?= GridView::widget(
                                    [
                                        'dataProvider' => $dataProvider,
                                        'showHeader' => true,
                                        'tableOptions' => ['class' => 'table table-hover'],
                                        'columns' => [
                                            'id',
                                            [
                                                'attribute' => 'timestamp',
                                                'label' => 'Creation Date',
                                                'value' => function ($model) {
                                                    $string = substr(
                                                        $model['timestamp'],
                                                        0,
                                                        strpos($model['timestamp'], ".")
                                                    );

                                                    return $string;
                                                }
                                            ],
                                            'oid',
                                            [
                                                'attribute' => 'payment_data',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    $payment_data = $model["payment_data"];
                                                    $payment_data = json_decode($payment_data, true);
                                                    if ($payment_data['type'] == 'sepadirectdebit') {
                                                        return "SEPA Direct Debit";
                                                    } elseif ($payment_data['type'] == 'scheme') {
                                                        return "Credit Card";
                                                    } else {
                                                        return "Unknown payment method";
                                                    }
                                                }
                                            ],
                                            'status',
                                            'amount',
                                            [
                                                'attribute' => 'psp_reference',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a(
                                                        $model["psp_reference"],
                                                        "https://ca-test.adyen.com/ca/ca/accounts/showTx.shtml?txType=Payment&pspReference="
                                                        . $model["psp_reference"]
                                                        . "&accountKey=MerchantAccount.IdentityBankBVEU",
                                                        ['target' => '_blank']
                                                    );
                                                }
                                            ]
                                        ],
                                    ]
                                ); ?>
                                <?= \yii\widgets\LinkPager::widget(
                                    [
                                        'pagination' => new Pagination(
                                            [
                                                'totalCount' => $dataProvider->getTotalCount(),
                                                'pageSize' => $dataProvider->pagination->getPageSize(),
                                            ]
                                        ),
                                        'firstPageLabel' => Translate::_('billing', 'First'),
                                        'lastPageLabel' => Translate::_('billing', 'Last')
                                    ]
                                ) ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Section-->
            </div>
        </div>
    </div>
</div>