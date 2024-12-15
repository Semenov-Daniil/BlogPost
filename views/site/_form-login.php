<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>

<div class="login-form-wrapp">

    <?= Alert::widget(); ?>
    
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
        'options' => [
            'data' => ['pjax' => true]
        ]
    ]); ?>
    
    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <div class="form-group">
        <div>
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

