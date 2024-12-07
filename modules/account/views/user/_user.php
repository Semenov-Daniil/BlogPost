<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var app\modules\account\models\UpdateUserForm $modelForm */

?>

<div class="account-user my-5 row g-0 gap-4">
    <div class="user-avatar col-6 col-md-3 d-flex flex-column gap-2">
        <?= Html::img('/' . ($model?->avatar ? $model->avatar->url : Yii::getAlias('@defaultAvatar')), ['class' => 'avatar img-thumbnail object-fit-cover', 'alt' => 'Аватарка']); ?>
        <?= Html::a('Изменить аватар', ['update-avatar'], ['class' => 'btn btn-primary btn-update-avatar', 'data' => ['pjax' => 0]]); ?>
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
                        <span class="col m-0"><?= Yii::$app->formatter->asDate($model->registered_at, 'dd.MM.yyyy'); ?></span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap  justify-content-md-end">
                <?= Html::a('Изменить личную информацию', ['update-info'], ['class' => 'btn btn-primary btn-update-info', 'data' => ['pjax' => 0]]); ?>
                <?= Html::a('Изменить пароль', ['change-password'], ['class' => 'btn btn-primary btn-change-password', 'data' => ['pjax' => 0]]); ?>
            </div>
        </div>
    </div>
</div>

<?php 

Modal::begin([
    'id' => 'modal-update-avatar',
    'title' => 'Изменение аватара',
    'size' => Modal::SIZE_LARGE,
]);

Modal::end(); 

Modal::begin([
    'id' => 'modal-update-info',
    'title' => 'Изменение личной инфорации',
    'size' => Modal::SIZE_LARGE,
]);

Modal::end(); 

Modal::begin([
    'id' => 'modal-change-password',
    'title' => 'Изменение пароля',
    'size' => Modal::SIZE_LARGE,
]);

Modal::end(); 


?>
