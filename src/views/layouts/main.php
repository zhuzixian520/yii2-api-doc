<?php

/* @var $this \yii\web\View */
/* @var $content string */

$logo_src = $this->params['logo_src'] ?? '';
$icp_num = $this->params['icp_num'] ?? '';
$icp_website = $this->params['icp_website'] ?? '';
$company_start_year = $this->params['company_start_year'] ?? '';
$copyright_website = $this->params['copyright_website'] ?? '';
$is_show_fae = $this->params['is_show_fae'] ?? '';
$fae_name = $this->params['fae_name'] ?? '';
$fae_website = $this->params['fae_website'] ?? '';

use zhuzixian520\api_doc\ApiDocAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$brandLabel = $logo_src ? '<img style="float: left;margin: -6px 8px 0 0;" src="' . $logo_src . '" height="32" width="32">' : '';

ApiDocAsset::register($this);
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
    <meta name="author" content="<?= Yii::$app->name;?>"/>
    <meta name="copyright" content="<?= Yii::$app->name;?>"/>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        //'brandImage' => '/img/logo_64_64.png',
        'brandLabel' => $brandLabel . '<span>' . Yii::$app->name . '</span>',
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
        <p class="pull-left">&copy; <?//= Html::encode(Yii::$app->name) ?> <?//= date('Y') ?></p>

        <p class="pull-right"><?//= Yii::powered() ?></p>
        -->

        <p class="pull-left">
            Copyright &copy; <?php if ($company_start_year) {?><?= $company_start_year;?> - <?php }?><?= date('Y') ?>
            <?php if ($copyright_website) {?>
            <a href="<?= $copyright_website;?>" target="_blank" rel="nofollow">
            <?php }?>
                <?= Yii::$app->name;?>
            <?php if ($copyright_website) {?>
            </a>
            <?php }?>
             版权所有;
            <?php if ($icp_num) {?>
             <a href="<?= $icp_website;?>" target="_blank" rel="nofollow"><?= $icp_num;?></a>;
            <?php }?>
        </p>
        <p class="pull-right"><?php if ($is_show_fae) {?>技术支持：<a href="<?= $fae_website;?>" title="<?= $fae_name;?>" target="_blank" rel="nofollow"><?= $fae_name;?></a><?php }?> 基于Yii <?= Yii::getVersion();?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
