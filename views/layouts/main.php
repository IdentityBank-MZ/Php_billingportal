<?php

use app\assets\AppAsset;
use app\helpers\Translate;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => 'IDB',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-inverse navbar-fixed-top',
            ],
        ]
    );
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => ['/']],
                ['label' => 'Businesses', 'url' => ['/business/default/index']],
                ['label' => 'Credits', 'url' => ['/credit/default/index']],
                ['label' => 'Packages', 'url' => ['/package/default/index']],
                ['label' => 'Invoices', 'url' => ['/invoice/default/index']],
                ['label' => 'Payments', 'url' => ['/payment/default/index']],
                Yii::$app->user->isGuest
                    ?
                    ['label' => 'Login', 'url' => ['/site/login']]
                    :
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->userId . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
            ],
        ]
    );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer" style="background: #101010">
    <div class="container">
        <p class="text-muted">&copy; <?= Translate::_('billing', 'Identity Bank') ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
