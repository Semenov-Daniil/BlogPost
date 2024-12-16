<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>

<?php Modal::begin([
    'id' => 'modal-delete-comment',
    'title' => 'Удаление комментария',
    'bodyOptions' => ['class' => 'py-4'],
    'options' => ['class' => 'user-select-none'],
    'size' => Modal::SIZE_EXTRA_LARGE
]); ?>

    <h5 class="modal-body-text">Вы точно хотите удалить комментарий и ответы на него?</h5>
    <div class="modal-action mt-4 d-flex">
        <?= Html::a('Удалить', ['/comment/delete'], ['class' => 'btn btn-outline-danger btn-delete ms-auto', 'data' => ['pjax' => 0]]); ?>
    </div>

<?php Modal::end(); ?>
