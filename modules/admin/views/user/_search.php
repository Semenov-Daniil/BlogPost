<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */

?>

<div class="user-search col-12 col-lg">

    <?php $form = ActiveForm::begin([
        'id' => 'user-search-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'd-flex flex-wrap gap-4'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{input}",
            'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3 p-0 mb-3'],
            'inputOptions' => ['class' => 'form-control'],
            'options' => [
                'class' => 'col-sm col-12'
            ]
        ],
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'id')->textInput(); ?>

    <?= $form->field($model, 'login')->textInput(); ?>

    <?php ActiveForm::end(); ?>

</div>