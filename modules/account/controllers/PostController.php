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

/**
 * PostController implements the CRUD actions for Posts model.
 */
class PostController extends Controller
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
                    'class' => VerbFilter::className(),
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
        Yii::$app->user->setReturnUrl(['index']);

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new UpdateUserForm();
        $model->attributes = Users::findOne(['id' => Yii::$app->user->id])->toArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'themes' => Themes::getThemes(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $post = $this->findModel($id);

        return $this->render('view', [
            'model' => $post,
            'updatePost' => Yii::$app->user->can('updatePost', ['author_id' => $post->users_id, 'status_id' => $post->statuses_id]),
            'deletePost' => Yii::$app->user->can('deletePost', ['author_id' => $post->users_id, 'count_comments' => $post->count_comments]),
        ]);
    }

    public function actionUpdateAvatar()
    {
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_UPDATE_AVATAR]);

            if ($this->request->isPost) {
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
    
                if ($model->updateAvatar()) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'success' => true,
                        'img' => $model->urlFile,
                    ];
    
                }
            }

            return $this->renderAjax('/user/_avatar-form', [
                'model' => $model
            ]);
        }

        return $this->redirect('index');
    }
    
    public function actionUpdateInfo()
    {
        
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_UPDATE_INFO]);
            $model->attributes = Users::findOne(['id' => Yii::$app->user->id])->toArray();

            if ($this->request->isPost && $model->load($this->request->post()) && $model->updateInfo()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'login' => Html::encode($model->login),
                ];
            }

            return $this->renderAjax('/user/_info-form', [
                'model' => $model,
            ]);
        }

        return $this->redirect('index');
    }

    public function actionChangePassword()
    {
        if ($this->request->isAjax) {
            $model = new UpdateUserForm(['scenario' => UpdateUserForm::SCENARIO_CHANGE_PASSWORD]);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->changePassword()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                ];
            }

            return $this->renderAjax('/user/_password-form', [
                'model' => $model,
            ]);
        }

        return $this->redirect('index');
    }

    public function actionUser()
    {
        $model = new UpdateUserForm();

        return $this->renderAjax('/user/_user', [
            'model' => Yii::$app->user->identity,
            'modelForm' => $model
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionModeration($id)
    {
        $model = $this->findModel($id);

        if ($model->statuses_id == Statuses::getStatus('Редактирование')) {
            $model->statuses_id = Statuses::getStatus('На модерации');
            $model->save(false);
        }

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new UpdateUserForm();
        $model->attributes = Users::findOne(['id' => Yii::$app->user->id])->toArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'themes' => Themes::getThemes(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::getPost($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
