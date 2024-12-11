<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UsersBlocks $model */
/** @var yii\bootstrap5\ActiveForm $form */

// $this->registerJsFile('js/createPost.js', ['depends' => YiiAsset::class]);

?>

<div class="block-form">
    <?php Pjax::begin([
        'id' => 'pjax-block',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'block-user-form',
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

        <?= $form->field($model, 'date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'value' => date('Y-m-d')]) ?>

        <?= $form->field($model, 'time')->textInput(['type' => 'time']) ?>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
