<?php

use app\models\Statuses;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var $deletePost */

?>

<div class="post">
    <div class="card">
        <?php if ($model->pathFile): ?>
            <img src="/<?= $model->pathFile ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
        <?php endif; ?>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title"><?= Html::encode($model->title); ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
            </div>
            <p class="card-text"><?= Html::encode($model->preview); ?></p>
            <div class="d-flex gap-2 flex-wrap">
                <?= Html::a('Читать пост', ['/post/view', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>

                <?php if (Yii::$app->user->can('updateOwnPost', ['post' => $model]) && ($model->statuses_id == Statuses::getStatus('Редактирование') || $model->statuses_id == Statuses::getStatus('Одобрен'))): ?>
                    <?= Html::a('Редактировать', ['/post/update', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
                <?php endif; ?>

                <?php if ($deletePost): ?>
                    <?php
                        Modal::begin([
                            'title' => 'Удаление поста',
                            'toggleButton' => ['label' => 'Удалить', 'class' => 'btn btn-danger'],
                            'bodyOptions' => ['class' => 'py-4'],
                            'footer' => Html::a('Удалить', ['/post/delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => ['method' => 'post'],
                            ]),
                            'options' => ['class' => 'user-select-none']
                        ]);
                        
                        echo 'Вы точно хотите удалить пост: ' . Html::encode($model->title) . '?';

                        Modal::end();
                    ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
