<?php

namespace app\modules\admin\controllers;

use app\models\Users;
use app\models\UsersBlocks;
use app\modules\admin\models\BlockForm;
use app\modules\admin\models\UsersSearch;
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
                if ($model->load($this->request->post()) && $model->unblockUser($id)) {
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Users();

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
     * Updates an existing Users model.
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
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
