<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>

<?php Modal::begin([
    'id' => 'modal-delete',
    'title' => 'Удаление поста',
    'options' => ['class' => 'user-select-none']
]); ?>
    
    <h5 class="modal-body-text">Вы точно хотите удалить пост?</h5>
    <div class="modal-action mt-4 d-flex">
        <?= Html::a('Удалить', ['/post/delete'], ['class' => 'btn btn-outline-danger btn-delete ms-auto', 'data' => ['pjax' => 0]]); ?>
    </div>

<?php Modal::end(); ?>
