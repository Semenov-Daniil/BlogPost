<?php

use app\models\Posts;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Themes $themes */
/** @var bool $deletePost */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/searchPosts.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/deletePostPjax.js', ['depends' => YiiAsset::class]);

?>
<div class="posts-index">

    <h3 class="mb-2"><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'pjax-posts',
        'enablePushState' => true,
        'timeout' => 5000
    ]); ?>

    <div class="cnt-search d-flex flex-wrap gap-4 justify-content-between align-items-end mb-4 mt-4">
        <div class="cnt-sorts">
            <p>Сортировка</p>
            <div class="sort-links d-flex flex-wrap gap-4">
                <?= $dataProvider->sort->link('created_at', ['label' => 'Дата создания', 'class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
        <div class="cnt-filter col-12 col-lg-8 col-xl-6 d-flex flex-wrap gap-4 align-items-end">
            <?php echo $this->render('_search', [
                'model' => $searchModel, 
                'themes' => $themes
            ]); ?>
            <div>
                <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "
            <div>{pager}</div>\n
            <div>{items}</div>\n
            <div class='mt-4'>{pager}</div>
        ",
        'itemOptions' => ['class' => 'item mt-4'],
        'itemView' => '_post',
        'viewParams' => [
            'deletePost' => $deletePost,
        ],
        'pager' => [
            'class' => LinkPager::class
        ],
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?= $this->render('_modal-delete'); ?>
