<?php

use app\models\Reactions;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var $deletePost */
/** @var $updateOwnPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="posts-view">

    <div class="post">
        <div class="post-header">
            <h3 class="mb-1"><?= Html::encode($this->title) ?></h3>
            <?php if ($model->pathFile): ?>
                <img src="/<?= $model->pathFile ?>" class="rounded mb-2 mt-3 card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
            <?php endif; ?>
            <h6 class="card-subtitle text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
        </div>
        <div class="post-body mt-4">
            <p class="card-text h5"><?= nl2br(Html::encode($model->text)); ?></p>
        </div>
        <div class="post-footer mt-4">
            <?= $this->render('_reactions', [
                'countLikes' => $model->likes,
                'countDislikes' => $model->dislikes,
                'activeLike' => Reactions::getLike(Yii::$app->user->id, $model->id),
                'activeDislike' => Reactions::getDislike(Yii::$app->user->id, $model->id),
                'postId' => $model->id,
                'pointer' => Yii::$app->user->can('reactionPost', ['post' => $model]),
            ])?>
            <div class="post-action d-flex gap-2 flex-wrap mt-4">
                <?php if ($updateOwnPost): ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
                <?php endif; ?>

                <?php if ($deletePost): ?>
                    <?php
                        Modal::begin([
                            'title' => 'Удаление поста',
                            'toggleButton' => ['label' => 'Удалить', 'class' => 'btn btn-danger'],
                            'bodyOptions' => ['class' => 'py-4'],
                            'footer' => Html::a('Удалить', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => ['method' => 'post'],
                            ]),
                            'options' => ['class' => 'user-select-none']
                        ]);
                        
                        echo 'Вы точно хотите удалить пост: ' . Html::encode($model->title) . '?';

                        Modal::end();
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
