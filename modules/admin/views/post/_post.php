<?php

use app\models\Statuses;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var array $stylesStatuses */

?>

<div class="post">
    <div class="card">
        <?php if ($model->pathFile): ?>
            <img src="/<?= $model->pathFile ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
        <?php endif; ?>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title row g-0 gap-2"><?= Html::encode($model->title); ?><span class="badge col-auto <?= $stylesStatuses[$model->status]; ?>"><?= Html::encode($model->status); ?></span></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
            </div>
            <p class="card-text"><?= Html::encode($model->preview); ?></p>
            <div class="d-flex gap-2 flex-wrap">
                <?= Html::a('Читать пост', ['/post/view', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>

                <?php if ($model->statuses_id == Statuses::getStatus('На модерации')): ?>
                    <?= Html::a('Одобрить', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
                    <?= Html::a('Запретить', ['prohibit', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
                <?php endif; ?>

                <?= Html::a('Удалить', ['/post/delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-delete', 'data' => ['title' => $model->title, 'pjax' => 0]]); ?>
            </div>
        </div>
    </div>
</div>
