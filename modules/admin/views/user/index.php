<?php

use app\models\Users;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\admin\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $blocksFilter */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['/panel-admin']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/admin.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('/js/searchUsers.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('/js/blockUsers.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('/js/unblockUsers.js', ['depends' => YiiAsset::class]);

?>
<div class="users-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="admin-action d-flex gap-3 my-4">
        <?= Html::a('Вернуться назад', ['/panel-admin'], ['class' => 'btn btn-outline-info']); ?>
    </div>

    <?php Pjax::begin([
        'id' => 'pjax-admin-users',
        'enablePushState' => false,
        'timeout' => 10000,
        'formSelector' => false
    ]); ?>
    
    <div class="cnt-search d-flex flex-wrap gap-4 justify-content-between align-items-end mb-4 mt-4">
        <div class="cnt-sorts">
            <p>Сортировка</p>
            <div class="sort-links d-flex flex-wrap gap-4">
                <?= $dataProvider->sort->link('id', ['class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
        <div class="cnt-filter col-12 col-lg-8 d-flex flex-wrap gap-4 align-items-end">
            <?php echo $this->render('_search', [
                'model' => $searchModel,
                'blocksFilter' => $blocksFilter
            ]); ?>
            <div>
                <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-outline-secondary btn-reset', 'data' => ['pjax' => 0]])?>
            </div>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item mt-3'],
        'itemView' => '_user',
        'layout' => "
            <div>{pager}</div>
            <div class='mt-3'>{items}</div>
            <div class='mt-3'>{pager}</div>
        ",
        'pager' => [
            'class' => LinkPager::class,
        ],
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?= $this->render('_modal-blocked'); ?>
