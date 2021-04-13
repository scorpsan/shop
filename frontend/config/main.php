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
                'RegistrationForm' => 'frontend\forms\RegistrationForm',
            ],
            'controllerMap' => [
                'profile' => 'frontend\controllers\user\ProfileController',
                'settings' => 'frontend\controllers\user\SettingsController',
                'registration' => 'frontend\controllers\user\RegistrationController',
                'security' => 'frontend\controllers\user\SecurityController',
                'address' => 'frontend\controllers\user\AddressController',
                'wishlist' => 'frontend\controllers\user\WishlistController',
            ],
            'mailParams' => [
                'fromEmail' => function() {
                    return [Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']];
                }
            ],
            'gdprPrivacyPolicyUrl' => ['/page/view', 'alias' => 'privacy'],
            'enableGdprCompliance' => true,
            'enableTwoFactorAuthentication' => false,
            'allowAccountDelete' => false,
            'enableEmailConfirmation' => true,
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
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            //'siteKeyV2' => 'your siteKey v2',
            //'secretV2' => 'your secret key v2',
            'siteKeyV3' => '6LcQH80ZAAAAAHcOaC4WK96xd0IhcF6cjbz1tRlL',
            'secretV3' => '6LcQH80ZAAAAAHQLv0uzEuFPNdJcX1qEp9kbDSPJ',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_PERMANENT,
            ],
            'rules' => require Yii::getAlias('@frontend/config/rules.php'),
        ],
    ],
    'params' => $params,
];
