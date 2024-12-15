<?php

use app\models\UsersBlocks;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UsersBlocks $model */
/** @var yii\bootstrap5\ActiveForm $form */

?>

<div class="block-form">
    <?php Pjax::begin([
        'id' => "pjax-block-$model->users_id",
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => "block-user-form-$model->users_id",
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
            'options' => [
                'class' => 'block-user-form',
                'data' => [
                    'id' => $model->users_id
                ]
            ]
        ]); ?>

        <?php if ($model->scenario == UsersBlocks::SCENARIO_TEMP_BLOCK): ?>
        <div class="row">
            <div class="col-lg col-12">
                <?= $form->field($model, 'date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'value' => date('Y-m-d')]) ?>
            </div>
            <div class="col-lg col-12">
                <?= $form->field($model, 'time')->textInput(['type' => 'time']) ?>
            </div>
        </div>
        <?php endif; ?>

        <?= $form->field($model, 'blocked_comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Заблокировать', ['class' => 'btn btn-success']) ?>
            <?= Html::button('Скрыть', ['class' => 'btn btn-primary btn-hide-collapse', 'data' => ['id' => $model->users_id]]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
