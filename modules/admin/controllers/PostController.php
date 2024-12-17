<?php

namespace app\modules\admin\controllers;

use app\models\Posts;
use app\models\Statuses;
use app\models\Themes;
use app\modules\admin\models\PostsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Posts model.
 */
class PostController extends Controller
{
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
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);

        if ($model->statuses_id == Statuses::getIdByTitle('На модерации')) {
            $model->statuses_id = Statuses::getIdByTitle('Одобрен');
            $model->save(false);
            Yii::$app->session->setFlash('info', 'Вы изменили статус поста.');
        }

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => $searchModel->getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }

    public function actionProhibit($id)
    {
        $model = $this->findModel($id);

        if ($model->statuses_id == Statuses::getIdByTitle('На модерации')) {
            $model->statuses_id = Statuses::getIdByTitle('Запрещен');
            $model->save(false);
            Yii::$app->session->setFlash('info', 'Вы изменили статус поста.');
        }

        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => $searchModel->getStatuses(),
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
        if (($model = Posts::getPost($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
