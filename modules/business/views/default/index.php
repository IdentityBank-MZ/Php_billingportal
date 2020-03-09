<?php

use app\helpers\Translate;
use idbyii2\widgets\FlashMessage;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;

$now = new DateTime();

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

                                <?= FlashMessage::widget(
                                    [
                                        'success' => Yii::$app->session->hasFlash('success')
                                            ? Yii::$app->session->getFlash(
                                                'success'
                                            ) : null,
                                        'error' => Yii::$app->session->hasFlash('error') ? Yii::$app->session->getFlash(
                                            'error'
                                        )
                                            : null,
                                        'info' => Yii::$app->session->hasFlash('info') ? Yii::$app->session->getFlash(
                                            'info'
                                        )
                                            : null,
                                    ]
                                ); ?>

                                <?= GridView::widget(
                                    [
                                        'dataProvider' => $dataProvider,
                                        'showHeader' => true,
                                        'tableOptions' => ['class' => 'table table-hover'],
                                        'rowOptions' => function ($model) use ($now) {
                                            if (
                                                $now->getTimestamp() > (new DateTime(
                                                    $model['next_payment']
                                                ))->getTimestamp()
                                            ) {
                                                return ['class' => 'danger'];
                                            }
                                        },
                                        'columns' => [
                                            'id',
                                            [
                                                'attribute' => 'bid',
                                                'format' => 'html',
                                                'label' => Translate::_('billing', 'Business ID')
                                            ],
                                            'data',
                                            'package_id',
                                            'credits',
                                            'base_credits',
                                            'additional_credits',
                                            'duration',
                                            'start_date',
                                            'end_date',
                                            'last_payment',
                                            'next_payment',
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{send}',
                                                'contentOptions' => ['style' => 'width: 120px; text-align:center;'],
                                                'buttons' => [
                                                    'send' => function (
                                                        $url,
                                                        $model,
                                                        $key
                                                    ) use ($now) {
                                                        if (
                                                            $now->getTimestamp() > (new DateTime(
                                                                $model['next_payment']
                                                            ))->getTimestamp()
                                                        ) {

                                                            return Html::a(
                                                                '<i class="glyphicon glyphicon-send"></i>',
                                                                ['send-payment-request', 'oid' => $model['bid']],
                                                                [
                                                                    'onclick' => "return confirm('" . Translate::_(
                                                                            'billing',
                                                                            'Are you sure you want to send reminder to this business?'
                                                                        ) . "');",
                                                                    'class' => 'btn btn-success btn-lg'
                                                                ]
                                                            );
                                                        }
                                                    }
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
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Section-->
            </div>
        </div>
    </div>
</div>