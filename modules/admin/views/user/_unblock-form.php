<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UsersBlocks $model */
/** @var yii\bootstrap5\ActiveForm $form */

?>

<div class="unblock-form">
    <?php Pjax::begin([
        'id' => "pjax-unblock-$model->id",
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => "unblock-user-form-$model->id",
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
            'options' => [
                'class' => 'unblock-user-form',
                'data' => [
                    'id' => $model->id
                ]
            ]
        ]); ?>

        <?= $form->field($model, 'unblocked_comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Разблокировать', ['class' => 'btn btn-success']) ?>
            <?= Html::button('Скрыть', ['class' => 'btn btn-primary btn-hide-collapse', 'data' => ['id' => $model->id]]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
