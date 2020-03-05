<?php

use app\assets\AppAsset;
use app\helpers\Translate;
use idbyii2\helpers\StaticContentHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

$mainAssetBundle = AppAsset::register($this);

$this->title = $title;
$logo = Yii::getAlias('@app') . '/views/assets/images/idblogo.png';

?>

<style>
    .mfa-store-logo {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>

<div class="container">
    <div class="header clearfix text-center">
        <h1 class="text-muted"><?= $issuer ?></h1>
    </div>

    <hr>

    <div class="row text-center">
        <div class="col-md-12">
            <div class="jumbotron">

                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="text-muted"><?= $userId ?></h5>
                        <h5 class="text-muted"><?= $accountNumber ?></h5>
                        <br>
                        <div>
                            <?= Html::img($mfaQr, ['alt' => 'MFA QR']) ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h5 class="text-muted"></h5>
                        <?= Translate::_(
                            'billing',
                            'Provide two consecutive authentication codes to verify.'
                        ) ?>
                        <br>&nbsp;<br>&nbsp;<br>
                        <?php $form = ActiveForm::begin(
                            [
                                'fieldConfig' => [
                                    'template' => "{input}"
                                ]
                            ]
                        ); ?>

                        <div>
                            <?= $form->field($model, 'code')->textInput(
                                [
                                    'placeholder' => Translate::_('billing', 'Authentication Code 1'),
                                    'style' => 'text-align: center;'
                                ]
                            )->widget(
                                MaskedInput::className(),
                                [
                                    'mask' => '999 999',
                                ]
                            ) ?>
                            <?= $form->field($model, 'code_next')->textInput(
                                [
                                    'placeholder' => Translate::_('billing', 'Authentication Code 2'),
                                    'style' => 'text-align: center;'
                                ]
                            )->widget(
                                MaskedInput::className(),
                                [
                                    'mask' => '999 999',
                                ]
                            ) ?>
                            <?= Html::submitButton(
                                Translate::_('billing', 'Authenticate Virtual MFA'),
                                [
                                    'class' => 'btn btn-success',
                                    'style' => 'text-align: center; width: 100%;',
                                    'id' => 'save'
                                ]
                            ) ?>
                            <?= $form->field($model, 'mfa')->hiddenInput()->label(false); ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <div class="text-center"><?= Translate::_('billing', 'OR ') ?></div>
                        <br>
                        <div>
                            <?= Html::a(
                                Translate::_('billing', 'Cancel and return to the login page'),
                                ['logout'],
                                [
                                    'class' => 'btn btn-warning',
                                    'style' => 'text-align: center; width: 100%;',
                                    'id' => 'cancel'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<footer class="footer text-center">
    <p style="padding-top: 15px;">
        <?= StaticContentHelper::getFooter(['footer_language' => Yii::$app->language]); ?>
    </p>
</footer>

<script>
    function initPage() {
        $("#dynamicmodel-code").css('text-align', 'center');
        $("#dynamicmodel-code").focus();
        $("#dynamicmodel-code_next").css('text-align', 'center');
    }
    <?php $this->registerJs("initPage();", View::POS_END); ?>
</script>
