<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-lg-5">

            <?php Pjax::begin([
                'id' => 'pjax-register-form',
                'enablePushState' => false,
                'timeout' => 10000,
            ]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                    'options' => [
                        ['enctype' => 'multipart/form-data'],
                        'data' => ['pjax' => true]
                    ]
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'surname')->textInput() ?>
                <?= $form->field($model, 'patronymic')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+7(999)-999-99-99',
                ]) ?>   
                <?= $form->field($model, 'login')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <?= $form->field($model, 'uploadFile')->fileInput() ?>
                <?= $form->field($model, 'rules')->checkbox() ?>

                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
