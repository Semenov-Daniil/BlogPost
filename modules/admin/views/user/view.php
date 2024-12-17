<?php

use app\models\Users;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\Users $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h3>Пользователь: <?= Html::encode($this->title) ?></h3>

    <div class="admin-action d-flex gap-3 my-4">
        <?= Html::a('Вернуться назад', ['/panel-admin/user/index'], ['class' => 'btn btn-outline-info']); ?>
    </div>

    <?php Pjax::begin(); ?>

    <?= $this->render('_info-user', [
        'model' => $model
    ]); ?>

    <div class="mt-4">
        <h4 class="my-3">История блокировок</h4>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item mt-3'],
            'itemView' => '_block-user',
            'layout' => "
                <div>{pager}</div>
                <div class='mt-3'>{items}</div>
                <div class='mt-3'>{pager}</div>
            ",
            'pager' => [
                'class' => LinkPager::class,
            ],
        ]) ?>
    </div>

    <?php Pjax::end(); ?>

</div>
