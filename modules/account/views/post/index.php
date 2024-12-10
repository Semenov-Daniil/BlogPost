<?php

use app\models\Posts;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
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
/** @var array $themes */
/** @var array $stylesStatuses */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/account.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('/js/searchPosts.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('/js/deletePost.js', ['depends' => YiiAsset::class]);

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
        <?= Html::a('Создать пост', ['/post/create'], ['class' => 'btn btn-success my-3']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'pjax-user-posts',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>

    <h4 class="my-3">Мои посты</h4>

    <div class="cnt-search d-flex flex-wrap gap-4 justify-content-between align-items-end mb-4 mt-4">
        <div class="cnt-sorts">
            <p>Сортировка</p>
            <div class="sort-links d-flex flex-wrap gap-4">
                <?= $dataProvider->sort->link('created_at', ['label' => 'Дата и время создания', 'class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
        <div class="cnt-filter col-12 col-lg-8 col-xl-6 d-flex flex-wrap gap-4 align-items-end">
            <?php echo $this->render('_search', ['model' => $searchModel, 'themes' => $themes]); ?>
            <div>
                <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-outline-secondary btn-reset', 'data' => ['pjax' => 0]])?>
            </div>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item mt-3'],
        'itemView' => '_post',
        'layout' => "
            <div>{pager}</div>
            <div class='mt-3'>{items}</div>
            <div class='mt-3'>{pager}</div>
        ",
        'pager' => [
            'class' => LinkPager::class,
        ],
        'viewParams' => [
            'stylesStatuses' => $stylesStatuses
        ]
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php Modal::begin([
    'id' => 'modal-delete',
    'title' => 'Удаление поста',
    'bodyOptions' => ['class' => 'py-4'],
    'options' => ['class' => 'user-select-none']
]); ?>
    
    <h5 class="modal-body-text">Вы точно хотите удалить пост?</h5>
    <div class="modal-action mt-4 d-flex">
        <?= Html::a('Удалить', ['/post/delete'], ['class' => 'btn btn-danger btn-delete ms-auto', 'data' => ['pjax' => 0]]); ?>
    </div>

<?php Modal::end(); ?>
