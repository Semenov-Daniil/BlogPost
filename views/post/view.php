<?php

use app\models\Reactions;
use app\models\Statuses;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var app\models\Comments $comment */
/** @var yii\data\ActiveDataProvider $dataProviderComments */
/** @var bool $deletePost */
/** @var bool $updatePost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('js/deletePost.js', ['depends' => YiiAsset::class]);
$this->registerJsFile('js/reactionPost.js', ['depends' => YiiAsset::class]);

?>
<div class="posts-view">

    <?= Html::a('Вернуться назад', Yii::$app->user->returnUrl, ['class' => 'btn btn-outline-info my-3']); ?>

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

            <?= $this->render('_reactions', [
                'countLikes' => $model->countLikes,
                'countDislikes' => $model->countDislikes,
                'activeLike' => Reactions::getLike(Yii::$app->user->id, $model->id),
                'activeDislike' => Reactions::getDislike(Yii::$app->user->id, $model->id),
                'postId' => $model->id,
                'pointer' => Yii::$app->user->can('reactionPost', ['author_id' => $model->users_id]),
            ]); ?>

            <?php if ($updatePost || $deletePost): ?>
                <div class="post-action d-flex gap-2 flex-wrap mt-4">

                    <?php if ($updatePost): ?>
                        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-warning']); ?>
                    <?php endif; ?>

                    <?php if ($deletePost): ?>
                        <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-outline-danger btn-delete', 'data' => ['title' => Html::encode($model->title)]]); ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <?= $this->render('@app/views/comment/_comments', [
        'comment' => $comment,
        'post' => $model,
        'dataProviderComments' => $dataProviderComments
    ])?>

</div>

<?= $this->render('_modal-delete'); ?>
