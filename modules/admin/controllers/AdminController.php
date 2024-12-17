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
use yii\helpers\VarDumper;

/**
 * AdminController implements the CRUD actions for Posts model.
 */
class AdminController extends Controller
{
    /**
     * Lists all Posts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->user->setReturnUrl('/panel-admin');
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Themes::getThemes(),
            'statuses' => $searchModel->getStatuses(),
            'stylesStatuses' => Statuses::getStylesStatus(),
        ]);
    }
}
