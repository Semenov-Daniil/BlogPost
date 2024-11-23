<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PostsSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Themes $themes */

?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'id' => 'posts-search-form',
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
                'class' => ''
            ]
        ],
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['data' => ['url' => '/post/index']]); ?>

    <?= $form->field($model, 'themes_id')->dropDownList($themes, ['prompt' => 'Все темы', 'style' => 'width: 13rem;', 'encodeSpaces' => true, 'data' => ['url' => '/post/index']]) ?>

    <?php ActiveForm::end(); ?>

</div>
