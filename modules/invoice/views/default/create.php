<?php

use idbyii2\helpers\Translate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo "not implemented";
exit();
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top: 100px">
    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-8" style="margin-left: 30px; margin-top: 30px">
                        <h1><?= Html::encode($this->title) ?></h1>

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'order')->textInput() ?>
                        <?= $form->field($model, 'credits')->textInput() ?>
                        <?= $form->field($model, 'duration')->textInput() ?>
                        <?= $form->field($model, 'price')->textInput() ?>
                        <?= $form->field($model, 'currency')->textInput() ?>
                        <?= $form->field($model, 'image')->textInput() ?>
                        <?= $form->field($model, 'included')->textInput() ?>
                        <?= $form->field($model, 'excluded')->textInput() ?>
                        <?= $form->field($model, 'tag')->textInput() ?>
                        <?= $form->field($model, 'active')->textInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton(Translate::_('billing', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>
</div>
