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
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3']],
            ['label' => 'О нас', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3']],
            ['label' => 'Посты', 'url' => ['/post/index'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3']],
            ['label' => 'Регистрация', 'url' => ['/site/register'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Вход', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3'], 'visible' => Yii::$app->user->isGuest],
            !Yii::$app->user->isGuest 
            ? [
                'label' => Html::img('/' . (Yii::$app->user->identity?->avatar ? Yii::$app->user->identity->avatar->url : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar me-1 object-fit-cover', 'alt' => 'Аватарка']) . Yii::$app->user->identity->login,
                'items' => [
                    ['label' => 'Личный кабинет', 'url' => '#'],
                    '-',
                    ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['class' => 'btn btn-dark me-1 px-3', 'data' => ['method' => 'post']]],
                ],
                'linkOptions' => ['class' => 'me-1 px-3 py-1 icon-link'],
                'encode' => false
            ]
            : '',
            
            Yii::$app->user->can('createPost')
                ? '<li class="nav-item">' . Html::a('Создать пост', ['/post/create'], ['class' => 'btn btn-info']) . '</li>'
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
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
