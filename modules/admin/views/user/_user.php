<?php

use app\models\Statuses;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var array $stylesStatuses */

?>

<div class="user">
    <div class="card">
        <div class="row g-0">
            <div class="col-12 col-lg-auto d-flex align-items-center border-bottom border-lg-end">
                <div class="card-body">
                    <h5 class="text-body-secondary row g-0 gap-2 m-0"># <?= $model->id ?></h5>
                </div>
            </div>
            <div class="col-12 col-lg">
                <div class="card-body">
                    <h5 class="card-title row g-0 gap-2"><?= Html::encode($model->surname); ?> <?= Html::encode($model->name); ?> <?= Html::encode($model->patronymic); ?><span class="badge col-auto <?= ($model->isBlock ? 'text-bg-danger' : 'text-bg-success'); ?>"><?= ($model->isBlock ? 'Заблокированный' : 'Активный'); ?></span></h5>
                    <h6 class="card-subtitle text-body-secondary"><?= Html::encode($model->login); ?></h6>
                </div>
            </div>
            <div class="col-12 col-lg-auto d-flex border-top border-lg-start">
                <div class="card-body d-flex gap-3 flex-wrap align-content-center">
                <?php if(!$model->isBlock): ?>
                    <?= Html::a('Заблокировать на время', ['temporary-block', 'id' => $model->id], ['class' => 'btn btn-outline-warning btn-temp-block', 'data' => ['id' => $model->id, 'pjax' => 0]]); ?>
                    <?= Html::a('Заблокировать навсегда', ['permanens-block', 'id' => $model->id], ['class' => 'btn btn-outline-danger btn-perm-block', 'data' => ['id' => $model->id, 'pjax' => 0]]); ?>
                <?php elseif (!$model->isPermBlock): ?>
                    <?= Html::a('Разблокировать', ['unblock', 'id' => $model->id], ['class' => 'btn btn-outline-success btn-unblock', 'data' => ['id' => $model->id, 'pjax' => 0]]); ?>
                <?php endif; ?>
                <?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'data' => ['pjax' => 0]]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="collapse" id="collapseBlockUser<?= $model->id ?>">
        <div class="card card-body mt-3"></div>
    </div>
</div>
