<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Comments $model */
/** @var int $postId */
/** @var bool $createAnswer */
/** @var bool $deleteComment */

?>

<div class="comment">
    <div class="card">
        <div class="comment-body card-body">
            <h6 class="card-subtitle text-body-secondary d-flex align-items-center gap-2">
                <span class="d-flex gap-2 align-items-center"><?= Html::img('/' . ($model?->avatarUrl ? $model->avatarUrl : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar-cicle object-fit-cover', 'alt' => 'Аватарка']) ?><?=  Html::encode($model->author); ?></span> | <span><?= Yii::$app->formatter->asDatetime($model->created_at); ?></span></h6>
            <p class="card-text mt-3"><?= nl2br(Html::encode($model->comment)); ?></p>

            <?php if ($createAnswer || $deleteComment): ?>
                <div class="comment-action">

                    <?php if ($createAnswer && is_null($model->parent_id)): ?>
                        <?= Html::a('Написать ответ', ['/comment/create-answer', 'commentId' => $model->id, 'postId' => $postId], ['class' => 'btn btn-outline-primary btn-sm btn-answer-comment', 'data-bs-toggle' => 'collapse', 'role' => 'button', 'aria-expanded' => 'false', 'aria-controls' => "collapseAnswerForm$model->id"]) ?>
                    <?php endif; ?>

                    <?php if ($deleteComment): ?>
                        <?= Html::a('Удалить', ['/post/delete'], ['class' => 'btn btn-outline-danger btn-delete-comment ms-auto', 'data' => ['pjax' => 0]]); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="collapse" id="collapseAnswerForm<?= $model->id ?>">
        <div class="card card-body mt-3"></div>
    </div>

    <?php if(!empty($model->answers)): ?>
        <div class="cnt-answers ms-4">
            <?= ListView::widget([
                'dataProvider' => new ArrayDataProvider(['allModels' => $model->answers]),
                'layout' => "<div>{items}</div>",
                'itemOptions' => ['class' => 'item mt-3'],
                'itemView' => '_comment',
                'viewParams' => [
                    'createAnswer' => false,
                    'deleteComment' => Yii::$app->user->can('deleteComment'),
                    'postId' => $postId,
                ],
            ]) ?>
        </div>
    <?php endif; ?>
</div>


