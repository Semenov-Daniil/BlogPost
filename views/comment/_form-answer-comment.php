<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Comments $model */
/** @var int $commentId */

?>

<div class="cnt-answer-comment">
    <?php Pjax::begin([
        'id' => "pjax-answer-comment-$commentId",
        'enablePushState' => false,
        'timeout' => 10000,
    ])?>
    <?php $form = ActiveForm::begin([
        'id' => "create-answer-comment-form-$commentId",
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-12 col-form-label mr-lg-3 pt-0'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
        'options' => [
            'class' => 'create-answer-comment-form',
            'data' => [
                'id' => $commentId,
                'pjax' => 0,
            ],
        ]
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label('Написать ответ на комментарий') ?>

    <?= Html::submitButton('Отправить ответ комментарий', ['class' => 'btn btn-outline-success', 'name' => 'create-answer-comment']) ?>

    <?php ActiveForm::end(); ?>
</div>

