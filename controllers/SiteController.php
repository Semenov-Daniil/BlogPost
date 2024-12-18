<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Posts;
use app\models\RegisterForm;
use app\models\UsersBlocks;
use app\widgets\Alert;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login', 'register'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->user->isGuest ? $this->redirect('/site/login') : $this->redirect('/');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                    'login' => ['POST', 'GET'],
                    'register' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->user->setReturnUrl(['/']);
        $posts = Posts::getLastPosts(10);

        return $this->render('index', [
            'posts' => $posts
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($this->request->isAjax) {

            if ($this->request->isPost) {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                    if ($model->user->isBlocked()) {
                        $this->response->format = Response::FORMAT_JSON;
                        return [
                            'isBlock' => true,
                            'data' => $this->renderAjax('_info-block', [
                                'model' => UsersBlocks::findLastBlock($model->user->id),
                            ])
                        ];
                    }

                    if ($model->login()) {
                        Yii::$app->session->setFlash('success', 'Вы успешно вошли в аккаунт ' . Yii::$app->user->identity->login . '.');
                        return $this->redirect([(Yii::$app->user->can('author') ? '/account' : '/panel-admin')]);
                    }
                }
            }

            return $this->renderAjax('_form-login', [
                'model' => $model,
            ]);
        }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($this->request->isAjax) {

            if ($model->load(Yii::$app->request->post())) {
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

                if ($model->register()) {
                    Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались под ' . Yii::$app->user->identity->login . '.');
                    return $this->redirect(['/account']);
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('info', 'Вы вышли из аккаунта.');
        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return Response
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAlert()
    {
        return $this->renderAjax('_alert');
    }
}
