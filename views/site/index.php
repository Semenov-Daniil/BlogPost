<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $posts */

use yii\bootstrap5\Html;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <?= ListView::widget([
        'dataProvider' => $posts,
        'layout' => "{items}",
        'itemOptions' => ['class' => 'item mb-4'],
        'itemView' => '_post',
        'emptyText' => false,
        'options' => [
            'class' => 'mt-3'
        ]
    ]) ?>
</div>
