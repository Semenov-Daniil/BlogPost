<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Пост - не вопрос!',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower'         => '@vendor/bower-asset',
        '@npm'           => '@vendor/npm-asset',
        '@avatars'       => 'img/avatars',
        '@defaultAvatar' => '@avatars/default.jpg',
        '@posts'         => 'img/posts',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'zfwqB4nFevUPGKVGiwC4b3g-ok4s6Kgz',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/account/<action>' => '/account/account/<action>',
                '/account/<controller>/<action>' => '/account/<controller>/<action>',

                '/panel-admin/<action>' => '/panel-admin/admin/<action>',
                '/panel-admin/<controller>/<action>' => '/panel-admin/<controller>/<action>',
            ],
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Etc/GMT-3',
            'timeZone' => 'Europe/Moscow',
            'datetimeFormat' => 'HH:mm dd.MM.yyyy',
            'timeFormat' => 'HH:mm',
            'locale' => 'ru-RU',
            'language' => 'ru-RU',
       ],

       'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['admin', 'author'],
        ],
        
    ],
    'modules' => [
        'account' => [
            'class' => 'app\modules\account\Module',
            'defaultRoute' => 'account'
        ],
        'panel-admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'post'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
