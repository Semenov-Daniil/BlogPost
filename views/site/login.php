<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

$this->title = 'Вход';
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
            <?php Pjax::end(); ?>

            <div style="color:#999;">
                Вы можете фойти под <strong>admin/pa55WORD</strong> или <strong>user/pa55WORD</strong>.<br>
            </div>

        </div>
    </div>
</div>
