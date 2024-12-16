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
        <?= Html::a('Изменить аватар', ['update-avatar'], ['class' => 'btn btn-outline-primary btn-update-avatar', 'data' => ['pjax' => 0]]); ?>
    </div>
    <div class="card col-md col-12">
        <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex flex-column gap-3 my-auto">
                <div class="row g-0 gap-4 row-gap-4 flex-wrap">
                    <div class="col-md">
                        <p class="card-subtitle text-body-secondary">ФИО</p>
                        <h5 class="card-title m-0"><?= Html::encode($model->surname); ?> <?= Html::encode($model->name); ?><?= Html::encode($model->patronymic ? " $model->patronymic" : ''); ?></h5>
                    </div>
                    <div class="col">
                        <p class="card-subtitle text-body-secondary">Логин</p>
                        <h5 class="card-title m-0"><?= Html::encode($model->login); ?></h5>
                    </div>
                </div>
                <div class="row g-0 gap-4 row-gap-4 flex-wrap">
                    <div class="col-md">
                        <p class="card-subtitle text-body-secondary">Email</p>
                        <h5 class="card-title m-0"><?= Html::encode($model->email); ?></h5>
                    </div>
                    <div class="col">
                        <p class="card-subtitle text-body-secondary">Телефон</p>
                        <h5 class="card-title m-0"><?= Html::encode($model->phone); ?></h5>
                    </div>
                </div>
                <div class="">
                    <p class="card-subtitle text-body-secondary">Дата регистрации</p>
                    <h5 class="card-title m-0"><?= Yii::$app->formatter->asDate($model->registered_at, 'dd.MM.yyyy'); ?></h5>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap  justify-content-md-end">
                <?= Html::a('Изменить личную информацию', ['update-info'], ['class' => 'btn btn-outline-primary btn-update-info', 'data' => ['pjax' => 0]]); ?>
                <?= Html::a('Изменить пароль', ['change-password'], ['class' => 'btn btn-outline-primary btn-change-password', 'data' => ['pjax' => 0]]); ?>
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
