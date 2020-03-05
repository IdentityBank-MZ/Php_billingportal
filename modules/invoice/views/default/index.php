<?php

use app\helpers\Translate;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
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
                                            'payment_id',
                                            [
                                                'attribute' => 'invoice_data',
                                                'format' => 'html',
                                                'value' => function ($model) {
                                                    $invoice_data = json_decode($model['invoice_data'], true);;
                                                    $string = "name: " . $invoice_data['items']['name'] . "<br>value: "
                                                        . $invoice_data['items']['value'];

                                                    return $string;
                                                }
                                            ],
                                            'invoice_number',
                                            'amount',
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
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{show}',
                                                'contentOptions' => ['style' => 'width:15px;'],
                                                'buttons' => [
                                                    'show' => function (
                                                        $url,
                                                        $model,
                                                        $key
                                                    ) {     // render your custom button
                                                        return Html::a(
                                                            '<span class="glyphicon glyphicon-eye-open"></span>',
                                                            Url::to(['show', 'id' => $model['id']]),
                                                            ['data-pjax' => 0, 'target' => "_blank"]
                                                        );
                                                    },
                                                ]
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