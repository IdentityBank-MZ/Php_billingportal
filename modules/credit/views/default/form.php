<?php

use idbyii2\helpers\Translate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
                                <h3><?= Translate::_('billing', Html::encode($this->title)) ?></h3>

                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'credits')->textInput() ?>
                                <?= $form->field($model, 'action_type')->textInput() ?>
                                <?= $form->field($model, 'action_name')->textInput() ?>

                                <div class="form-group">
                                    <?= Html::submitButton(
                                        Translate::_('billing', 'Save'),
                                        ['class' => 'btn btn-success']
                                    ) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Section-->
            </div>
        </div>
    </div>
</div>