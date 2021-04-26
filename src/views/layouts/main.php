<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $logo_src string */

use api_cms\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\components\SysCfg;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="<?= Yii::$app->name;?>"/>
    <meta name="keywords" content="<?= Yii::$app->name;?>"/>
    <meta name="author" content="<?= SysCfg::COMPANY_SHORT;?>"/>
    <meta name="copyright" content="<?= SysCfg::COMPANY;?>"/>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        //'brandImage' => '/img/logo_64_64.png',
        'brandLabel' => '<img style="float: left;margin: -6px 8px 0 0;" src="/img/logo_64_64.png" height="32"><span>' . Yii::$app->name . '</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Gii', 'url' => ['/gii']],
        ['label' => 'Debug', 'url' => ['/debug']],
    ];
    /*if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }*/
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <!--
        <p class="pull-left">&copy; <?//= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?//= Yii::powered() ?></p>
        -->

        <p class="pull-left"><?= SysCfg::COPYRIGHT;?> <?= SysCfg::ICP;?></p>
        <p class="pull-right"><?= SysCfg::FAE;?> 基于Yii <?= Yii::getVersion();?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
