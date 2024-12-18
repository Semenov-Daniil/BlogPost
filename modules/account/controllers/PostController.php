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
            'stylesStatuses' => Statuses::getStylesStatus(),
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

        if ($this->request->isPost && $model->statuses_id == Statuses::getIdByTitle('Редактирование')) {
            $model->statuses_id = Statuses::getIdByTitle('На модерации');
            $model->save(false);
            Yii::$app->session->setFlash('info', 'Вы отправили пост на модерацию.');
        }
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

        throw new NotFoundHttpException('Пост не найден.');
    }
}
