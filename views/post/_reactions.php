<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var $countLikes */
/** @var $countDislikes */
/** @var $postId */
/** @var $pointer */
/** @var $activeLike */
/** @var $activeDislike */

?>

<?php Pjax::begin([
    'id' => 'pjax-reactions',
    'enablePushState' => false,
    'timeout' => 5000,
]); ?>

    <div class="post-reactions d-flex gap-2 flex-wrap">
        <?= Html::a("👍 <span class='count-reaction'>$countLikes</span>", ['reaction', 'postId' => $postId, 'reaction' => 1], ['class' => 'btn btn-reaction' . ($activeLike ? ' btn-primary' : ' btn-outline-primary') . ($pointer ? '' : '  pe-none'), 'data' => ['pjax' => 0]]); ?>
        <?= Html::a("👎 <span class='count-reaction'>$countDislikes</span>", ['reaction', 'postId' => $postId, 'reaction' => 0], ['class' => 'btn btn-reaction' . ($activeDislike ? ' btn-primary' : ' btn-outline-primary') . ($pointer ? '' : '  pe-none'), 'data' => ['pjax' => 0]]); ?>
    </div>

<?php Pjax::end();?>
