<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Comments $model */
/** @var int $postId */

?>

<div class="cnt-create-comment">
    <?php $form = ActiveForm::begin([
        'id' => 'create-comment-form',
        'action' => ['/comment/create', 'postId' => $postId],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
        'options' => [
            'data' => [
                'pjax' => true
            ],
        ]
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label('Написать комментарий') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить комментарий', ['class' => 'btn btn-outline-success', 'name' => 'create-comment']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

