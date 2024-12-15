<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

/** @var app\models\UsersBlocks $model */

?>

<div class="block-user d-flex flex-column gap-3">
    <h5>Вас заблокировали <?= $model->unblocked_at ? 'на время' : 'навсегда' ?>.</h5>

    <?php if ($model->unblocked_at): ?>
    <div>
        <p class="card-subtitle text-body-secondary">Время разблокировки</p>
        <h5 class="card-title mb-2"><?= Yii::$app->formatter->asDatetime($model->unblocked_at, 'HH:mm dd.MM.yyyy'); ?></h5>
    </div>
    <?php endif; ?>

    <div>
        <p class="card-subtitle text-body-secondary">Причина блокировки</p>
        <h5 class="card-title mb-2"><?= nl2br(Html::encode($model->blocked_comment)); ?></h5>
    </div>
</div>