<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Comments $model */
/** @var app\models\AnswersComments $answer */
/** @var $createAnswer */
/** @var $deleteComment */
/** @var app\models\Post $post */
/** @var $isAnswer */

?>

<div class="comment">
    <div class="card">
        <div class="comment-body card-body">
            <h6 class="card-subtitle text-body-secondary d-flex align-items-center gap-2">
                <span class="d-flex gap-2 align-items-center"><?= Html::img('/' . ($model?->avatarUrl ? $model->avatarUrl : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar  object-fit-cover', 'alt' => 'Аватарка']) ?><?=  Html::encode($model->author); ?></span> | <span><?= Yii::$app->formatter->asDatetime($model->created_at); ?></span></h6>
            <p class="card-text mt-3"><?= nl2br(Html::encode($model->comment)); ?></p>
            <?php if ($createAnswer || $deleteComment): ?>
            <div>
                <?php if ($createAnswer && !$isAnswer): ?>
                <?= Html::a('Написать ответ', "#collapseAnswerForm$model->id", ['class' => 'btn btn-primary', "data-bs-toggle" => "collapse", "role" => "button", "aria-expanded" => "false", "aria-controls" => "collapseAnswerForm"]) ?>
                <div class="collapse mt-3" id="collapseAnswerForm<?= $model->id ?>">
                    <div class="card card-body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'create-answer-comment-form',
                            'action' => ['/comment/create-answer', 'commentId' => $model->id, 'postId' => $post->id],
                            'fieldConfig' => [
                                'template' => "{label}\n{input}\n{error}",
                                'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                                'inputOptions' => ['class' => 'form-control'],
                                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                            ],
                            'options' => [
                                'data' => ['pjax' => true]
                            ]
                        ]); ?>
                    
                        <?= $form->field($answer, 'answer')->textarea(['rows' => 6])->label('Написать ответ на комментарий') ?>
                    
                        <?= Html::submitButton('Отправить ответ комментарий', ['class' => 'btn btn-success', 'name' => 'create-answer-comment']) ?>
                    
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($deleteComment): ?>
                <?php Modal::begin([
                    'title' => 'Удаление комментария',
                    'toggleButton' => ['label' => 'Удалить', 'class' => 'btn btn-danger'],
                    'bodyOptions' => ['class' => 'py-4'],
                    'footer' => Html::a('Удалить', ['/comment/' . ($isAnswer ? 'answer-delete' : 'delete'), 'id' => $model->id, 'postId' => $post->id], [
                        'class' => 'btn btn-danger',
                        'data' => ['method' => 'post', 'pjax' => true],
                        "data-bs-dismiss" => "modal"
                    ]),
                    'options' => ['class' => 'user-select-none'],
                    'size' => Modal::SIZE_EXTRA_LARGE
                ]); ?>

                    <h5 class="card-title">Вы точно хотите удалить комментарий?</h5>
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="card-subtitle text-body-secondary d-flex align-items-center gap-2"><span class="d-flex gap-2 align-items-center"><?= Html::img('/' . ($model?->avatarUrl ? $model->avatarUrl : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar  object-fit-cover', 'alt' => 'Аватарка']) ?><?=  Html::encode($model->author); ?></span> | <span><?= Yii::$app->formatter->asDatetime($model->created_at); ?></span></h6>
                            </div>
                            <p class="card-text"><?= nl2br(Html::encode($model->comment)); ?></p>
                        </div>
                    </div>

                <?php Modal::end(); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($model->answers)): ?>
    <div class="cnt-answers ms-4">
        <?= ListView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $model->answers]),
            'layout' => "<div>{items}</div>",
            'itemOptions' => ['class' => 'item mt-3'],
            'itemView' => '_comment',
            'viewParams' => [
                'answer' => $answer,
                'createAnswer' => Yii::$app->user->can('createAnswer', ['post' => $post]),
                'deleteComment' => Yii::$app->user->can('deleteComment'),
                'post' => $post,
                'isAnswer' => true,
            ],
        ]) ?>
    </div>
    <?php endif; ?>
</div>
