<?php

namespace app\controllers;

use app\models\AnswersComments;
use app\models\Comments;
use app\models\Posts;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * CommentController implements the CRUD actions for Comments model.
 */
class CommentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['createComment'],
                            'roleParams' => function($rule) {
                                return [
                                    'author_id' => $this->findModelPost(Yii::$app->request->get('postId')),
                                ];
                            },
                        ],
                        [
                            'actions' => ['create-answer'],
                            'allow' => true,
                            'roles' => ['createAnswer'],
                            'roleParams' => function($rule) {
                                return [
                                    'author_id' => $this->findModelPost(Yii::$app->request->get('postId')),
                                ];
                            },
                        ],
                        [
                            'actions' => ['delete', 'answer-delete'],
                            'allow' => true,
                            'roles' => ['deleteComment'], 
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->user->isGuest ? $this->redirect('/site/login') : $this->redirect('/');
                    }
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['GET', 'POST'],
                        'create' => ['POST'],
                        'create-answer' => ['GET', 'POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($postId)
    {
        $model = new Comments();

        if ($this->request->isAjax) {
            if ($model->load($this->request->post()) && $model->createComment($postId)) {
                $model->comment = '';
            }
        }

        return $this->renderAjax('_comments', [
            'comment' => $model,
            'post' => $this->findModelPost($postId),
            'dataProviderComments' => Comments::getComments($postId),
        ]);
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateAnswer($commentId, $postId)
    {
        $model = new Comments();

        if ($this->request->isAjax) {

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->createAnswerComment($commentId, $postId)) {
                    $model->comment = '';

                    return $this->asJson([
                        'success' => true,
                    ]);
                }
            }

            return $this->renderAjax('_form-answer-comment', [
                'model' => $model,
                'commentId' => $commentId,
            ]);
        }
    }

    /**
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isAjax) {
            
            if ($this->request->isPost) {
                $model->delete();
            }

            return $this->renderAjax('_comment', [
                'model' => $model,
                'postId' => null,
                'createAnswer' => false,
                'deleteComment' => false
            ]);
        }
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comments::getComment($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPost($id)
    {
        if (($model = Posts::getPost($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
