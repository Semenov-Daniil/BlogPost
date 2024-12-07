<?php

use app\models\Posts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JsExpression;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\account\models\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\modules\account\models\UpdateUserForm $model */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/account.js', ['depends' => YiiAsset::class]);

?>
<div class="account-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'pjax-user',
        'enablePushState' => false,
        'timeout' => 10000,
        'formSelector' => false,
    ]); ?>
        <?= $this->render('/user/_user', [
            'model' => Yii::$app->user->identity,
            'modelForm' => $model,
        ]) ?>
    <?php Pjax::end(); ?>

    <p>
        <?= Html::a('Создать пост', ['/post/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        },
    ]) ?>

    <?php Pjax::end(); ?>

</div>
