<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var app\models\Users $modelUser */

?>

<div class="account-user my-5 row g-0 gap-4">
    <div class="user-avatar col-6 col-md-3 d-flex flex-column gap-2">
        <?= Html::img('/' . ($model?->avatar ? $model->avatar->url : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar img-thumbnail object-fit-cover', 'alt' => 'Аватарка']); ?>
        <?php Modal::begin([
            'id' => 'modal-update-avatar',
            'title' => 'Изменение аватара',
            'toggleButton' => ['label' => 'Изменить аватар', 'class' => 'btn btn-primary', 'type' => "button"],
        ]); ?>
            <?php $form = ActiveForm::begin([
                'id' => 'change-avatar-form',
                'action' => ['change-avatar'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'data' => ['pjax' => true]
                ]
            ]); ?>

                <?= $form->field($modelUser, 'uploadFile')->fileInput() ?>

                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Изменить аватар', ['class' => 'btn btn-success', 'id' => 'btn-update-avatar']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>
    </div>
    <div class="card col-md col-12">
        <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex flex-column gap-3 h5 my-auto">
                <div class="row g-0 gap-3 gap-md-5 flex-wrap">
                    <div class="col-md row g-0 gap-2">
                        <span class="text-secondary col-auto">ФИО: </span>
                        <span class="col-auto m-0"><?= Html::encode("$model->surname $model->name $model->patronymic"); ?></span>
                    </div>
                    <div class="col-md row g-0 gap-2">
                        <span class="text-secondary col-auto">Логин: </span>
                        <span class="col-auto m-0"><?= Html::encode($model->login); ?></span>
                    </div>
                </div>
                <div class="row g-0 gap-3 gap-md-5 flex-wrap">
                    <div class="col-md row g-0 gap-2">
                        <span class="text-secondary col-auto">Электронная почта: </span>
                        <span class="col m-0"><?= Html::encode($model->email); ?></span>
                    </div>
                    <div class="col-md row g-0 gap-2">
                        <span class="text-secondary col-auto">Телефон: </span>
                        <span class="col m-0"><?= Html::encode($model->phone); ?></span>
                    </div>
                </div>
                <div class="row g-0 gap-3 gap-md-5 flex-wrap">
                    <div class="col-md row g-0 gap-2">
                        <span class="text-secondary col-auto">Дата регистрации: </span>
                        <span class="col m-0"><?= Yii::$app->formatter->asDate($model->registered_at, 'long'); ?></span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap  justify-content-md-end">
                <?= Html::button('Изменить информацию', ['class' => 'btn btn-primary']); ?>
                <?= Html::button('Изменить пароль', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </div>
</div>
