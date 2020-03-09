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

                                <?php if(Yii::$app->session->hasFlash('dangerMessage')): ?>
                                    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('dangerMessage') ?></div>
                                <?php endif; ?>

                                <h2><?= Translate::_('billing', Html::encode($this->title)) ?></h2>

                                <p><?= Html::a(
                                        Translate::_('billing', 'Add') . ' <i class="glyphicon glyphicon-plus"></i>',
                                        Url::to(['default/create']),
                                        ['class' => 'btn btn-primary']
                                    ); ?></p>
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget(
                                    [
                                        'dataProvider' => $dataProvider,
                                        'showHeader' => true,
                                        'tableOptions' => ['class' => 'table table-hover'],
                                        'columns' => [
                                            'id',
                                            'order',
                                            'credits',
                                            'duration',
                                            'name',
                                            'price',
                                            'currency',
                                            //'image',
                                            'included',
                                            'excluded',
                                            //'tag',
                                            [
                                                'attribute' => 'active',
                                                'format' => 'html',
                                                'value' => function ($model) {
                                                    if ($model['active'] == 1) {
                                                        return "<span class=\"glyphicon glyphicon-ok\" style=\"color:green\"></span>";
                                                    } else {
                                                        return "<span class=\"glyphicon glyphicon-minus\" style=\"color:red\"></span>";
                                                    }
                                                }
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'template' => '{edit} {delete}',
                                                'contentOptions' => ['style' => 'width: 100px;'],
                                                'buttons' => [
                                                    'edit' => function (
                                                        $url,
                                                        $model,
                                                        $key
                                                    ) {     // render your custom button
                                                        return Html::a(
                                                            '<i class="glyphicon glyphicon-pencil"></i>',
                                                            Url::toRoute(['default/edit', 'id' => $model['id']], true)
                                                        );
                                                    },
                                                    'delete' => function (
                                                        $url,
                                                        $model,
                                                        $key
                                                    ) {     // render your custom button
                                                        return Html::a(
                                                            '<i class="glyphicon glyphicon-trash"></i>',
                                                            Url::toRoute(['default/delete', 'id' => $model['id']], true),
                                                            [
                                                                'onclick' => "return confirm('" . Translate::_(
                                                                        'billing',
                                                                        'Are you sure you want to delete this package?'
                                                                    ) . "');",
                                                            ]
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