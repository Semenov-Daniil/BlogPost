<?php

use app\models\Statuses;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\UsersBlocks $model */

?>

<div class="block-user">
    <div class="card">
        <div class="card-body row g-0 d-flex gap-5 row-gap-4 flex-wrap">
            <div class="block-info col-12 col-lg row g-0 gap-3">
                <div class="col-12 row g-0">
                    <div class="col">
                        <p class="card-subtitle text-body-secondary">Время блокировки</p>
                        <h6 class="card-title mb-2 h5"><?= Yii::$app->formatter->asDatetime($model->blocked_at, 'HH:mm dd.MM.yyyy'); ?></h6>
                    </div>
                    <div class="col">
                        <p class="card-subtitle text-body-secondary">Время разблокировки</p>
                        <h6 class="card-title mb-2 h5"><?= ($model->unblocked_at ? Yii::$app->formatter->asDatetime($model->unblocked_at, 'HH:mm dd.MM.yyyy') : 'Навсегда'); ?></h6>
                    </div>
                </div>
                <div class="col-12">
                    <p class="card-subtitle text-body-secondary">Причина блокировки</p>
                    <h6 class="card-title mb-2 h5"><?= nl2br(Html::encode($model->blocked_comment)); ?></h6>
                </div>
            </div>
            <div class="unblock-info col-12 col-lg row g-0 gap-3">
                <?php if ($model->pre_unblocked_at): ?>
                <div>
                    <p class="card-subtitle text-body-secondary">Время предварительной разблокировки</p>
                    <h6 class="card-title mb-2 h5"><?= Yii::$app->formatter->asDatetime($model->pre_unblocked_at, 'HH:mm dd.MM.yyyy'); ?></h6>
                </div>
                <div>
                    <p class="card-subtitle text-body-secondary">Причина предварительной разблокировки</p>
                    <h6 class="card-title mb-2 h5"><?= nl2br(Html::encode($model->unblocked_comment)); ?></h6>
                </div>
                <? endif; ?>
            </div>
            <div class="block-status col-12">
                <h6 class="card-title mb-2 h5">Статус <span class="badge <?= ($model->is_active ? 'text-bg-danger' : 'text-bg-secondary') ?>"><?= ($model->is_active ? 'Активна' : 'Неактивна'); ?></span></h6>
            </div>
        </div>
    </div>
</div>
