<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var array $themes */

$this->registerJsFile('js/createPost.js', ['depends' => YiiAsset::class])

?>

<div class="posts-form">

    <?php Pjax::begin([
        'id' => 'pjax-create-post',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'create-post-form',
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

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'themes_id')->dropDownList($themes, ['prompt' => 'Выберите тему', 'disabled' => $model->check]) ?>

        <?= $form->field($model, 'check')->checkbox() ?>

        <?= $form->field($model, 'theme')->textInput(['maxlength' => true, 'disabled' => !$model->check]) ?>

        <?= $form->field($model, 'uploadFile')->fileInput() ?>
        
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
