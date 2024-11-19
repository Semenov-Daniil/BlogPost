<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $posts */

use yii\bootstrap5\Html;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <h3 class="mb-5"><?= Html::encode($this->title) ?></h3>

    <?= ListView::widget([
        'dataProvider' => $posts,
        'layout' => "{items}",
        'itemOptions' => ['class' => 'item mb-4'],
        'itemView' => '/post/_post',
    ]) ?>
</div>
