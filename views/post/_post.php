<?php

use app\models\Statuses;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var bool $deletePost */

?>

<div class="post">
    <div class="card">
        <?php if ($model->pathFile): ?>
            <img src="/<?= $model->pathFile ?>" class="card-img-top object-fit-cover post-img" alt="Изображение поста">
        <?php endif; ?>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title"><?= Html::encode($model->title); ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
            </div>
            <p class="card-text"><?= Html::encode($model->preview); ?></p>
            <div class="d-flex gap-2 flex-wrap">
                <?= Html::a('Читать пост', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-info']); ?>

                <?php if (Yii::$app->user->can('updatePost', ['author_id' => $model->users_id, 'status_id' => $model->statuses_id])): ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-warning']); ?>
                <?php endif; ?>

                <?php if ($deletePost): ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-outline-danger btn-delete', 'data' => ['title' => Html::encode($model->title), 'pjax' => 0]]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
