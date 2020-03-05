<?php

use app\assets\AppAsset;
use app\helpers\Translate;
use idbyii2\helpers\StaticContentHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\MaskedInput;

$mainAssetBundle = AppAsset::register($this);

$this->title = Translate::_('billing', 'Multi-factor Authentication');
$userId = ((empty(Yii::$app->user->identity->userId)) ? '' : Yii::$app->user->identity->userId);
?>

<div class="container">
    <div class="header clearfix text-center">
        <h3 class="text-muted"><?= $this->title ?></h3>
    </div>

    <hr>

    <div class="row text-center">
        <div class="col-md-6 col-md-offset-3">
            <div class="jumbotron">
                <h2 style="color: #428bca;">Identity Bank</h2>
                <p class="lead" style="color: #5cb85c;"><?= $userId ?></p>
                <p>
                    <?php $form = ActiveForm::begin(
                        [
                            'fieldConfig' => [
                                'template' => "{input}"
                            ],
                            'options' => ['class' => 'lockscreen-credentials']
                        ]
                    ); ?>

                <div>
                    <?= $form->field($model, 'code')->textInput(
                        [
                            'class' => 'form-control',
                            'placeholder' => Translate::_('billing', 'MFA Code')
                        ]
                    )->widget(
                        MaskedInput::className(),
                        [
                            'mask' => '999 999',
                        ]
                    ) ?>
                    <?= Html::submitButton(
                        Translate::_('billing', 'Submit'),
                        [
                            'class' => 'btn btn-success',
                            'id' => 'save',
                            'style' => 'text-align: center; width: 100%;',
                        ]
                    ) ?>
                </div>
                <?php ActiveForm::end(); ?>
                </p>
                <div class="help-block text-center">
                    <?= Translate::_('billing', 'Please enter an MFA code to complete sign-in.') ?>
                </div>
                <div class="text-center">
                    <a href="<?= Url::toRoute(['logout'], true) ?>"><?= Translate::_(
                            'billing',
                            'Or sign in as a different user'
                        ) ?></a>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <footer class="footer text-center">
        <p>
            <?= StaticContentHelper::getFooter(['footer_language' => Yii::$app->language]); ?>
        </p>
    </footer>
</div>

<script>
    function initMfa() {
        $("#dynamicmodel-code").focus();
        $("#dynamicmodel-code").css('text-align', 'center');
    }
    <?php $this->registerJs("initMfa();", View::POS_END); ?>
</script>
