<?php

use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\modules\account\models\UpdateUserForm $model */
/** @var array $themes */
/** @var array $statuses */
/** @var array $stylesStatuses */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/updateAvatar.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/updateInfoUser.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/updatePasswordUser.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/searchPosts.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/deletePostPjax.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/accountChangeStatusPost.js', ['depends' => YiiAsset::class]);

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
        <?= Html::a('Создать пост', ['/post/create'], ['class' => 'btn btn-info px-3 py-2 my-3']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'pjax-user-posts',
        'enablePushState' => true,
        'timeout' => 10000,
    ]); ?>

    <h4 class="my-3">Мои посты</h4>

    <?= Alert::widget(); ?>

    <div class="cnt-search d-flex flex-wrap gap-4 justify-content-between align-items-end mb-4 mt-4">
        <div class="cnt-sorts">
            <p>Сортировка</p>
            <div class="sort-links d-flex flex-wrap gap-4">
                <?= $dataProvider->sort->link('created_at', ['label' => 'Дата и время создания', 'class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
        <div class="cnt-filter col-12 col-lg-8 d-flex flex-wrap gap-4 align-items-end">
            <?php echo $this->render('_search', [
                'model' => $searchModel, 
                'themes' => $themes,
                'statuses' => $statuses
            ]); ?>
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

<?= $this->render('@app/views/post/_modal-delete'); ?>
