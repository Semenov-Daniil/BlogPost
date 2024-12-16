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

<div class="change-password-cnt">

    <?php Pjax::begin([
        'id' => 'pjax-change-password',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'change-password-form',
            'action' => ['change-password'],
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

            <?= $form->field($model, 'old_password')->passwordInput() ?>
            <?= $form->field($model, 'new_password')->passwordInput() ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <div class="d-flex flex-wrap gap-2 justify-content-between mt-3">
                <?= Html::button('Назад', ['class' => 'btn btn-outline-info', 'data-bs-dismiss' => 'modal']) ?>
                <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-outline-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
