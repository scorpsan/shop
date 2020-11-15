<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'shop-frontend',
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        'frontend\bootstrap\SetUp',
    ],
    'layout' => 'page',
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'classMap' => [
                'User' => common\models\User::class,
            ],
            'controllerMap' => [
                'profile' => 'frontend\controllers\ProfileController'
            ],
            'gdprPrivacyPolicyUrl' => ['/privacy'],
            'routes' => [],
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl'=>'',
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            'name' => 'shop-frontend',
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
                    '@Da/User/resources/views' => '@frontend/views/user'
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru'],
            'enableLocaleUrls' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
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
                '' => 'page/index',
                '<_a:(login|logout)>' => 'user/security/<_a>',
                '<_a:(register|resend)>' => 'user/registration/<_a>',
                'user/forgot' => 'user/recovery/request',
                'user/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
                'user/confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/registration/confirm',
                'user/profile' => 'user/profile/index',
                'user/profile/<_a:[\w\-]+>' => 'user/settings/<_a>',
                'search' => 'page/search',
                '<alias:[\w_-]+>' => 'page/view',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
