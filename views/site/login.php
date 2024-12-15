<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/login.js', ['depends' => YiiAsset::class]);

?>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-lg-5">

            <?php Pjax::begin([
                'id' => 'pjax-login-form',
                'enablePushState' => false,
                'timeout' => 10000,
            ]); ?>

                <?= $this->render('_form-login', [
                    'model' => $model
                ]); ?>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>

<?php

Modal::begin([
    'id' => 'modal-block',
    'title' => 'Вы заблокированы!',
    // 'centerVertical' => true,
    'size' => Modal::SIZE_LARGE
]);

Modal::end();

?>
