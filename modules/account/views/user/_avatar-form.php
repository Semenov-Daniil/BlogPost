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

<div class="update-avatar-cnt">

    <?php Pjax::begin([
        'id' => 'pjax-update-avatar',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'update-avatar-form',
            'action' => ['update-avatar'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3 pt-0'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
            'options' => [
                'enctype' => 'multipart/form-data',
                'data' => ['pjax' => true]
            ]
        ]); ?>

            <?= $form->field($model, 'uploadFile')->fileInput()->label('Загрузите аватар') ?>

            <div class="avatar-wrapp d-flex">
                <?= Html::img('/' . (Yii::$app->user->identity?->avatar ? Yii::$app->user->identity->avatar->url : Yii::getAlias('@defaultAvatar')), ['id' => 'userAvatar', 'class' => 'avatar-cicle-xl object-fit-cover mx-auto', 'alt' => 'Аватарка']); ?>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-between mt-3">
                <?= Html::button('Назад', ['class' => 'btn btn-outline-info', 'data-bs-dismiss' => 'modal']) ?>
                <?= Html::submitButton('Изменить аватар', ['class' => 'btn btn-outline-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
