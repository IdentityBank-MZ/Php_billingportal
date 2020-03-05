<?php

use app\assets\AppAsset;
use app\helpers\Translate;
use yii\helpers\Html;
use yii\helpers\Url;

$mainAssetBundle = AppAsset::register($this);

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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body" style="text-align: center;">
                                                <h5 class="card-title"><?= Translate::_('billing', 'Businesses') ?></h5>
                                                <p class="card-text"><span class="glyphicon glyphicon-usd"
                                                                           style="font-size:40px;"></span></p>
                                                <?= Html::a(
                                                    Translate::_('billing', 'Go to view'),
                                                    Url::toRoute(['/business/default/index']),
                                                    ['class' => 'btn btn-primary']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body" style="text-align: center;">
                                                <h5 class="card-title"><?= Translate::_('billing', 'Credits') ?></h5>
                                                <p class="card-text"><span class="glyphicon glyphicon-transfer"
                                                                           style="font-size:40px;"></span></p>
                                                <?= Html::a(
                                                    Translate::_('billing', 'Go to view'),
                                                    Url::toRoute(['/credit/default/index']),
                                                    ['class' => 'btn btn-primary']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed black;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body" style="text-align: center;">
                                                <h5 class="card-title"><?= Translate::_('billing', 'Package') ?></h5>
                                                <p class="card-text"><span class="glyphicon glyphicon-briefcase"
                                                                           style="font-size:40px;"></span></p>
                                                <?= Html::a(
                                                    Translate::_('billing', 'Go to view'),
                                                    Url::toRoute(['/package/default/index']),
                                                    ['class' => 'btn btn-primary']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body" style="text-align: center;">
                                                <h5 class="card-title"><?= Translate::_('billing', 'Invoices') ?></h5>
                                                <p class="card-text"><span class="glyphicon glyphicon-paste"
                                                                           style="font-size:40px;"></span></p>
                                                <?= Html::a(
                                                    Translate::_('billing', 'Go to view'),
                                                    Url::toRoute(['/invoice/default/index']),
                                                    ['class' => 'btn btn-primary']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed black;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h5 class="card-title"><?= Translate::_('billing', 'Payments') ?></h5>
                                                <p class="card-text"><span class="glyphicon glyphicon-credit-card"
                                                                           style="font-size:40px;"></span></p>
                                                <?= Html::a(
                                                    Translate::_('billing', 'Go to view'),
                                                    Url::toRoute(['/payment/default/index']),
                                                    ['class' => 'btn btn-primary']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Section-->
        </div>
    </div>
</div>