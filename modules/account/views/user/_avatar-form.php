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

    <?php $form = ActiveForm::begin([
        'id' => 'update-avatar-form',
        'action' => ['update-avatar'],
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

        <?= $form->field($model, 'uploadFile')->fileInput() ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Изменить аватар', ['class' => 'btn btn-success', 'id' => 'btn-update-avatar']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
