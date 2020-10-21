<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-seller',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'seller\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-seller',
        ],
        'view' => [
            'class' => 'seller\components\View',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-seller', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the seller
            'name' => 'advanced-seller',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'account/login' => 'site/login',
                'account/logout' => 'site/logout',
                'account/register' => 'site/register',
                'account/forgot-pass' => 'site/forgot-pass',
                '<controller:\w+>/<action:\w+>/<id\d+>' => '<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@seller/translations',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'forceCopy' => false,
        ],
    ],
    'params' => $params,
];
