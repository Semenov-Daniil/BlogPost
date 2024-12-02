<?php

namespace app\modules\account;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * account module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\account\controllers';

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
                            'allow' => true,
                            'roles' => ['author'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->user->isGuest ? $this->redirect('/site/login') : $this->redirect('/');
                    }
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
