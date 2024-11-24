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
                                    'post' => Posts::find()->select('users_id')->where(['id' => Yii::$app->request->get('postId')]),
                                ];
                            },
                        ],
                        [
                            'actions' => ['create-answer'],
                            'allow' => true,
                            'roles' => ['createAnswer'],
                            'roleParams' => function($rule) {
                                return [
                                    'post' => Posts::find()->select('users_id')->where(['id' => Yii::$app->request->get('postId')])->one(),
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
                        'delete' => ['POST'],
                        'answer-delete' => ['POST'],
                        'create' => ['POST'],
                        'create-answer' => ['POST'],
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

        return $this->renderAjax('/post/_comments', [
            'comment' => $model,
            'answer' => new AnswersComments(),
            'post' => Posts::find()->select('id', 'users_id')->where(['id' => $postId])->one(),
            'commentsDataProvider' => Comments::getComments($postId),
        ]);
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateAnswer($commentId, $postId)
    {
        $model = new AnswersComments();

        if ($this->request->isAjax) {
            if ($model->load($this->request->post()) && $model->createComment($commentId)) {
                $model->answer = '';
            }
        }

        return $this->renderAjax('/post/_comments', [
            'comment' => new Comments(),
            'answer' => $model,
            'post' => Posts::find()->select('id', 'users_id')->where(['id' => $postId])->one(),
            'commentsDataProvider' => Comments::getComments($postId),
        ]);
    }

    /**
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $postId)
    {
        $this->findModel($id)->delete();

        return $this->renderAjax('/post/_comments', [
            'comment' => new Comments(),
            'answer' => new AnswersComments(),
            'post' => Posts::find()->select('id', 'users_id')->where(['id' => $postId])->one(),
            'commentsDataProvider' => Comments::getComments($postId),
        ]);
    }

    /**
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAnswerDelete($id, $postId)
    {
        $this->findModelAnswer($id)->delete();

        return $this->renderAjax('/post/_comments', [
            'comment' => new Comments(),
            'answer' => new AnswersComments(),
            'post' => Posts::find()->select('id', 'users_id')->where(['id' => $postId])->one(),
            'commentsDataProvider' => Comments::getComments($postId),
        ]);
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
        if (($model = Comments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAnswer($id)
    {
        if (($model = AnswersComments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
