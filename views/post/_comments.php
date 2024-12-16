<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Comments $comment */
/** @var app\models\AnswersComments $answer */
/** @var app\models\Posts $post */
/** @var yii\data\ActiveDataProvider $commentsDataProvider */

var_dump(Yii::$app->user->can('createComment', ['author_id' => $post->users_id]));die;

?>

<?php Pjax::begin([
    'id' => 'pjax-comments',
    'enablePushState' => false,
    'timeout' => 5000,
    'options' => [
        'class' => 'mt-2'
    ]
]); ?>
    <?php if (Yii::$app->user->can('createComment', ['author_id' => $post->users_id])): ?>
    <div class="cnt-create-comment">
        <?php $form = ActiveForm::begin([
            'id' => 'create-comment-form',
            'action' => ['/comment/create', 'postId' => $post->id],
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
    
        <?= $form->field($comment, 'comment')->textarea(['rows' => 6])->label('Написать комментарий') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Отправить комментарий', ['class' => 'btn btn-success', 'name' => 'create-comment']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
    <?php endif; ?>
    <div class="cnt-comments mt-4">
        <?= ListView::widget([
            'dataProvider' => $commentsDataProvider,
            'layout' => "<div>{items}</div>",
            'itemOptions' => ['class' => 'item mt-3'],
            'itemView' => '_comment',
            'viewParams' => [
                'answer' => $answer,
                'createAnswer' => Yii::$app->user->can('createAnswer', ['post' => $post]),
                'deleteComment' => Yii::$app->user->can('deleteComment'),
                'post' => $post,
                'isAnswer' => false,
            ],
        ]) ?>
    </div>

<?php Pjax::end(); ?>
