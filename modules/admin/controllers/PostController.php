<?php

namespace app\modules\admin\controllers;

use app\models\Posts;
use app\models\Statuses;
use app\models\Themes;
use app\modules\admin\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => Statuses::getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);

        if ($model->statuses_id == Statuses::getStatus('На модерации')) {
            $model->statuses_id = Statuses::getStatus('Одобрен');
            $model->save();
        }

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => Statuses::getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    public function actionProhibit($id)
    {
        $model = $this->findModel($id);

        if ($model->statuses_id == Statuses::getStatus('На модерации')) {
            $model->statuses_id = Statuses::getStatus('Запрещен');
            $model->save();
        }

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => Statuses::getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
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
        if (($model = Posts::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
