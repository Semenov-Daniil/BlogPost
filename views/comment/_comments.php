<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Comments $comment */
/** @var app\models\Posts $post */
/** @var yii\data\ActiveDataProvider $dataProviderComments */

?>

<div class="cnt-comments mt-5">
    <h4>Комментарии <?= $dataProviderComments->getCount(); ?></h4>

    <?php Pjax::begin([
        'id' => 'pjax-comments',
        'enablePushState' => false,
        'timeout' => 5000,
        'options' => [
            'class' => 'mt-2'
        ]
    ]); ?>
    
        <?php if (Yii::$app->user->can('createComment', ['author_id' => $post->users_id])): ?>
            
            <?= $this->render('_form-comment', [
                'model' => $comment,
                'postId' => $post->id
            ])?>

        <?php endif; ?>

        <div class="cnt-comments mt-4">
            <?= ListView::widget([
                'dataProvider' => $dataProviderComments,
                'layout' => "<div>{items}</div>",
                'itemOptions' => ['class' => 'item mt-3'],
                'itemView' => '_comment',
                'viewParams' => [
                    'createAnswer' => Yii::$app->user->can('createAnswer', ['author_id' => $post->users_id]),
                    'deleteComment' => Yii::$app->user->can('deleteComment'),
                    'postId' => $post->id,
                ],
            ]) ?>
        </div>

    <?php Pjax::end(); ?>

    
</div>

