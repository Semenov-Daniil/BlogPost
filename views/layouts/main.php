<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100 position-relative">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top', 'data-bs-theme'=>"dark"],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto d-flex gap-2 align-items-center'],
        'route' => Yii::$app->request->getPathInfo(),
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index'], 'linkOptions' => ['class' => 'btn btn-dark px-3']],
            ['label' => 'О нас', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'btn btn-dark px-3']],
            ['label' => 'Посты', 'url' => ['/post/index'], 'linkOptions' => ['class' => 'btn btn-dark px-3']],
            ['label' => 'Регистрация', 'url' => ['/site/register'], 'linkOptions' => ['class' => 'btn btn-dark px-3'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Вход', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'btn btn-dark px-3'], 'visible' => Yii::$app->user->isGuest],
            !Yii::$app->user->isGuest 
            ? [
                'label' => Html::img('/' . (Yii::$app->user->identity?->avatar ? Yii::$app->user->identity->avatar->url : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar-cicle object-fit-cover', 'alt' => 'Аватарка']) . '<span class=\'user-login\'>' . Yii::$app->user->identity->login . '</span>',
                'items' => [
                    ['label' => 'Личный кабинет', 'url' => '/account', 'linkOptions' => ['class' => 'btn btn-dark px-3'], 'visible' => Yii::$app->user->can('author')],
                    ['label' => 'Панель администратора', 'url' => '/panel-admin', 'linkOptions' => ['class' => 'btn btn-dark px-3'], 'visible' => Yii::$app->user->can('admin')],
                    '-',
                    ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['class' => 'btn btn-dark px-3', 'data' => ['method' => 'post']]],
                ],
                'linkOptions' => ['class' => 'ps-1 pe-3 d-flex gap-2 align-items-center user-item'],
                'encode' => false,
                'options' => ['class' => 'test']
            ]
            : '',
            
            Yii::$app->user->can('createPost')
                ? '<li class="nav-item">' . Html::a('Создать пост', ['/post/create'], ['class' => 'btn btn-info px-3 py-2 border-0 d-block']) . '</li>'
                : ''
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?php Pjax::begin([
            'id' => 'pjax-alert',
            'enablePushState' => false
        ])?>
            <?= $this->render('@app/views/site/_alert'); ?>
        <?php Pjax::end(); ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">@ JavaLetS <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
