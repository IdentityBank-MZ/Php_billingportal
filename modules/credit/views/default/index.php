<?php

use app\helpers\Translate;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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

                                <p><?= Html::a(
                                        Translate::_('billing', 'Add') . ' <i class="glyphicon glyphicon-plus"></i>',
                                        Url::to(['default/create']),
                                        ['class' => 'btn btn-primary']
                                    ); ?></p>
                                <?= GridView::widget(
                                    [
                                        'dataProvider' => $dataProvider,
                                        'showHeader' => true,
                                        'tableOptions' => ['class' => 'table table-hover'],
                                        'columns' => [
                                            'id',
                                            'credits',
                                            'action_name',
                                            'action_type',
                                            [
                                                'class' => 'yii\grid\ActionColumn',
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
                                                            Url::toRoute(['default/delete', 'id' => $model['id']], true)
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
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Section-->
            </div>
        </div>
    </div>
</div>