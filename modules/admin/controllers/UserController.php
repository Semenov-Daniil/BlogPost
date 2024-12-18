<?php

namespace app\modules\admin\controllers;

use app\models\Users;
use app\models\UsersBlocks;
use app\modules\admin\models\BlockForm;
use app\modules\admin\models\UsersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends Controller
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
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocksFilter' => $searchModel->getFilterBlocks(),
        ]);
    }

    public function actionTemporaryBlock($id)
    {
        $model = new UsersBlocks(['scenario' => UsersBlocks::SCENARIO_TEMP_BLOCK, 'users_id' => $id]);

        if ($this->request->isAjax) {

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->tempBlockUser($id)) {
                    Yii::$app->session->setFlash('info', "Вы временно заблокировали пользователя #$id.");
                    $this->response->format = Response::FORMAT_JSON;
                    return [
                        'success' => true,
                    ];
                }
            }

            return $this->renderAjax('_block-form', [
                'model' => $model
            ]);
        }
    }

    public function actionPermanensBlock($id)
    {
        $model = new UsersBlocks(['scenario' => UsersBlocks::SCENARIO_PERM_BLOCK, 'users_id' => $id]);

        if ($this->request->isAjax) {

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->permBlockUser($id)) {
                    Yii::$app->session->setFlash('info', "Вы навсегда заблокировали пользователя #$id.");
                    $this->response->format = Response::FORMAT_JSON;
                    return [
                        'success' => true,
                    ];
                }
            }

            return $this->renderAjax('_block-form', [
                'model' => $model
            ]);
        }
    }

    public function actionUnblock($id)
    {
        $model = UsersBlocks::findLastBlock($id);
        $model->scenario = UsersBlocks::SCENARIO_UNBLOCK;

        if ($this->request->isAjax) {

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->unblockUser()) {
                    Yii::$app->session->setFlash('info', "Вы разблокировали пользователя #$id.");
                    $this->response->format = Response::FORMAT_JSON;
                    return [
                        'success' => true,
                    ];
                }
            }

            return $this->renderAjax('_unblock-form', [
                'model' => $model
            ]);
        }
    }

    /**
     * Displays a single Users model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = UsersBlocks::getListBlockUser($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
