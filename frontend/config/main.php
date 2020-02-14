<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                '' => '/article/article',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'category' => [
            'class' => 'frontend\modules\category\Category',
        ],
        'theme' => [
            'class' => 'frontend\modules\theme\Theme',
        ],
        'template' => [
            'class' => 'frontend\modules\template\Template',
        ],
        'image' => [
            'class' => 'frontend\modules\image\Image',
        ],
        'destination' => [
            'class' => 'frontend\modules\destination\Destination',
        ],
        'source' => [
            'class' => 'frontend\modules\source\Source',
        ],
        'article' => [
            'class' => 'frontend\modules\article\Article',
        ],
        'view' => [
            'class' => 'frontend\modules\view\View',
        ],
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
        'language' => [
            'class' => 'frontend\modules\language\Language',
        ],
        'api' => [
            'class' => 'frontend\modules\api\Api',
        ],
        'titlequeue' => [
            'class' => 'frontend\modules\titlequeue\Titlequeue',
        ],
    ],
];
