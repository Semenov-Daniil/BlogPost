<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var array $themes */

?>

<div class="post">

    <div class="card">
        <?php if ($model->pathFile): ?>
            <img src="/<?= $model->pathFile ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($model->title); ?></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->theme); ?> | <?= Html::encode($model->author); ?> | <?= Yii::$app->formatter->asDatetime($model->created_at); ?></h6>
            <p class="card-text"><?= Html::encode($model->preview); ?></p>
            <div>
                <?= Html::a('Читать', ['/post/view', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>

                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id): ?>
                    <?= Html::a('Редактировать', ['/post/update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
                <?php endif; ?>

                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
                    <?= Html::a('Удалить', ['/post/delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы точно хотите удалть данный пост?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
