<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'shop-backend',
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        'backend\bootstrap\SetUp',
    ],
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'classMap' => [
                'User' => common\models\User::class,
            ],
            'enableRegistration' => false,
            'routes' => [],
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl'=>'/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'session' => [
            'name' => 'shop-backend',
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@Da/User/resources/views' => '@backend/views/user'
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru'],
            'enableLocaleUrls' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            /**
             * @var array list of route and URL regex patterns to ignore during
             * language processing. The keys of the array are patterns for routes, the
             * values are patterns for URLs. Route patterns are checked during URL
             * creation. If a pattern matches, no language parameter will be added to
             * the created URL.  URL patterns are checked during processing incoming
             * requests. If a pattern matches, the language processing will be skipped
             * for that URL. Examples:
             *
             * ~~~php
             * [
             *     '#^site/(login|register)#' => '#^(login|register)#'
             *     '#^api/#' => '#^api/#',
             * ]
             * ~~~
             */
            'ignoreLanguageUrlPatterns' => [
                '#^favicon.ico#' => '#^favicon.ico#',
                '#^robots.txt#' => '#^robots.txt#',
                '#^elfinder#' => '#^elfinder#',
                '#^assets#' => '#^assets#',
                '#^files#' => '#^files#',
                '#^fonts#' => '#^fonts#',
                '#^icon#' => '#^icon#',
                '#^images#' => '#^images#',
            ],
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_PERMANENT,
            ],
            'rules' => [
                '' => 'site/index',
                'login' => 'user/security/login',
                'users/<_a:[\w\-]+>' => 'user/admin/<_a>',
                'users/<_c:[\w\-]+>/<_a:[\w\-]+>' => 'user/<_c>/<_a>',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
