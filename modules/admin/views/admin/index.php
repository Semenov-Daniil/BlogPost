<?php

use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $themes */
/** @var array $statuses */
/** @var array $stylesStatuses */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/admin.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/searchPosts.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/deletePostPjax.js', ['depends' => YiiAsset::class]);

?>
<div class="admin-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="admin-action d-flex gap-3 my-4">
        <?= Html::a('Список пользователей', ['/panel-admin/user/index'], ['class' => 'btn btn-primary']); ?>
    </div>

    <?php Pjax::begin([
        'id' => 'pjax-admin-posts',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>

    <h4>Все посты</h4>
    
    <div class="cnt-search d-flex flex-wrap gap-4 justify-content-between align-items-end my-3">
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
                'statuses' => $statuses,
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
