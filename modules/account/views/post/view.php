<?php

use app\models\Reactions;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var app\models\Comments $comment */
/** @var yii\data\ActiveDataProvider $dataProviderComments */
/** @var bool $deletePost */
/** @var bool $updatePost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/account']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('js/deletePost.js', ['depends' => YiiAsset::class]);

?>
<div class="posts-view">
    <?= Html::a('Вернуться назад', ['/account'], ['class' => 'btn btn-outline-info my-3']); ?>
    <div class="post">
        <div class="post-header">
            <h3 class="mb-1"><?= Html::encode($this->title) ?></h3>

            <?php if ($model->pathFile): ?>
                <img src="/<?= $model->pathFile ?>" class="post-img rounded mb-2 mt-3 card-img-top object-fit-cover" alt="Изображение поста">
            <?php endif; ?>

            <h6 class="card-subtitle text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
        </div>
        <div class="post-body mt-4">
            <p class="card-text h5"><?= nl2br(Html::encode($model->text)); ?></p>
        </div>
        <div class="post-footer mt-4">
            <?php if ($updatePost || $deletePost): ?>
                <div class="post-action d-flex gap-2 flex-wrap mt-4">

                    <?php if ($updatePost): ?>
                        <?= Html::a('Редактировать', ['/post/update', 'id' => $model->id], ['class' => 'btn btn-outline-warning']); ?>
                    <?php endif; ?>

                    <?php if ($deletePost): ?>
                        <?= Html::a('Удалить', ['/post/delete', 'id' => $model->id], ['class' => 'btn btn-outline-danger btn-delete', 'data' => ['title' => Html::encode($model->title)]]); ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->render('@app/views/post/_modal-delete'); ?>
