<?php

namespace app\controllers;

use app\models\AnswersComments;
use app\models\Comments;
use app\models\Posts;
use app\models\PostsSearch;
use app\models\Reactions;
use app\models\Themes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['createPost'],
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['updateOwnPost'],
                            'roleParams' => function($rule) {
                                return [
                                    'post' => $this->findModel(Yii::$app->request->get('id')),
                                ];
                            },
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['deletePost'],
                            'roleParams' => function($rule) {
                                if (Yii::$app->user->can('author')) {
                                    $post = $this->findModel(Yii::$app->request->get('id'));
    
                                    return [
                                        'post' => $post,
                                        'countComments' => 0,
                                    ];
                                }
                                return null;
                            },
                        ],
                        [
                            'actions' => ['reaction'],
                            'allow' => true,
                            'roles' => ['reactionPost'],
                            'roleParams' => function($rule) {
                                return [
                                    'post' => $this->findModel(Yii::$app->request->get('postId')),
                                ];
                            },
                        ]
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->user->isGuest ? $this->redirect('/site/login') : $this->redirect('/');
                    }
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'index' => ['GET'],
                        'view' => ['GET'],
                        'create' => ['GET', 'POST'],
                        'update' => ['GET', 'POST'],
                        'reaction' => ['POST'],
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
            'deletePost' => Yii::$app->user->can('deletePost'),
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
            'updateOwnPost' => Yii::$app->user->can('updateOwnPost', ['post' => $post]),
            'deletePost' => Yii::$app->user->can('deleteAuthorPost', ['post' => $post, 'countComments' => 0]),
            'comment' => new Comments(),
            'answer' => new AnswersComments(),
            'commentsDataProvider' => Comments::getComments($id),
        ]);
    }

    /**
     * Reaction posts.
     * @param int $postId ID
     * @param int $reaction reaction
     * @return string
     */
    public function actionReaction($postId, $reaction)
    {   
        
        $post = Posts::findOne(['id' => $postId]);

        if (!empty($post)) {
            Reactions::setReactionPost($postId, $reaction);

            return $this->renderAjax('_reactions', [
                'countLikes' => $post->likes,
                'countDislikes' => $post->dislikes,
                'activeLike' => Reactions::getLike(Yii::$app->user->id, $post->id),
                'activeDislike' => Reactions::getDislike(Yii::$app->user->id, $post->id),
                'postId' => $post->id,
                'pointer' => true,
            ]);
        }

        return $this->goHome()->send();
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($this->request->isAjax) {
            if ($model->load($this->request->post())) {
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

                if ($model->create()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'themes' => Themes::getThemes(),
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

        if ($this->request->isAjax) {
            if ($model->load($this->request->post())) {
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

                if ($model->updatePost()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'themes' => Themes::getThemes(),
        ]);
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deletePost();

        return $this->goBack();
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
