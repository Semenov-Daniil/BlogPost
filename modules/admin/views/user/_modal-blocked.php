<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>

<?php Modal::begin([
    'id' => 'modal-blocked',
    'title' => 'Постоянная блокировка пользователя',
    'options' => ['class' => 'user-select-none']
]); ?>
    
    <h5 class="modal-body-text">Вы точно хотите заблокировать пользователя?</h5>
    <p class="text-danger">При постоянной блокировке пользователя удаляются все его посты и дальнейшая разблокировка пользователя невозможна!</p>
    <div class="modal-action mt-4 d-flex">
        <?= Html::a('Заблокировать навсегда', ['permanens-block'], ['class' => 'btn btn-outline-danger btn-bloked ms-auto', 'data' => ['pjax' => 0]]); ?>
    </div>

<?php Modal::end(); ?>
