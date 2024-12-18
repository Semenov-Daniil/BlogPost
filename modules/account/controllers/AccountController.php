<?php

namespace app\modules\account\controllers;

use app\models\Posts;
use app\models\Statuses;
use app\models\Themes;
use app\models\Users;
use app\modules\account\models\UpdateUserForm;
use app\modules\account\models\PostsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class AccountController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Posts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->user->setReturnUrl(['/account/index']);

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new UpdateUserForm();
        $model->attributes = Users::findOne(['id' => Yii::$app->user->id])->toArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'themes' => Themes::getThemes(),
            'statuses' => Statuses::getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    public function actionUpdateAvatar()
    {
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_UPDATE_AVATAR]);

            if ($this->request->isPost) {
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
    
                if ($model->updateAvatar()) {
                    Yii::$app->session->setFlash('success', 'Вы успешно обновили автара.');
                    return $this->asJson([
                        'success' => true,
                        'img' => $model->urlFile,
                    ]);
                }
            }

            return $this->renderAjax('/user/_avatar-form', [
                'model' => $model
            ]);
        }
    }
    
    public function actionUpdateInfo()
    {
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_UPDATE_INFO]);
            $model->attributes = Users::findOne(['id' => Yii::$app->user->id])->toArray();

            if ($this->request->isPost && $model->load($this->request->post()) && $model->updateInfo()) {
                Yii::$app->session->setFlash('success', 'Вы успешно обновили личную информацию.');
                return $this->asJson([
                    'success' => true,
                    'login' => Html::encode($model->login),
                ]);
            }

            return $this->renderAjax('/user/_info-form', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword()
    {
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_CHANGE_PASSWORD]);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Вы успешно изменили пароль.');
                return $this->asJson([
                    'success' => true,
                ]);
            }

            return $this->renderAjax('/user/_password-form', [
                'model' => $model,
            ]);
        }
    }
}
