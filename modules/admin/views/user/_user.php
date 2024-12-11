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
        <div class="card-body">
            <div>
                <h5 class="card-title row g-0 gap-2">ID <?= $model->id ?></h5>
            </div>
            <div class="mt-3">
                <h5 class="card-title row g-0 gap-2"><?= Html::encode($model->surname); ?> <?= Html::encode($model->name); ?> <?= Html::encode($model->patronymic); ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->login); ?></h6>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-3">
                <?= Html::a('Заблокировать на время', ['temporary-block', 'id' => $model->id], ['class' => 'btn btn-primary btn-temp-block', 'data' => ['id' => $model->id, 'pjax' => 0]]); ?>
                <?= Html::a('Заблокировать навсегда', [''], ['class' => 'btn btn-primary']); ?>
                <?= Html::a('Разблокировать', [''], ['class' => 'btn btn-success']); ?>
            </div>
        </div>
    </div>
    <div class="collapse" id="collapseBlockUser<?= $model->id ?>">
        <div class="card card-body mt-3"></div>
    </div>
</div>
