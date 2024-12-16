<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\bootstrap5\ActiveForm $form */

?>

<div class="update-info-cnt">

    <?php Pjax::begin([
        'id' => 'pjax-update-info',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'update-info-form',
            'action' => ['update-info'],
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

            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'surname')->textInput() ?>
            <?= $form->field($model, 'patronymic')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '+7(999)-999-99-99',
            ]) ?>   
            <?= $form->field($model, 'login')->textInput() ?>

            <div class="d-flex flex-wrap gap-2 justify-content-between mt-3">
                <?= Html::button('Назад', ['class' => 'btn btn-outline-info', 'data-bs-dismiss' => 'modal']) ?>
                <?= Html::submitButton('Изменить личную информацию', ['class' => 'btn btn-outline-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
