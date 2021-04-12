<?php
return [
    'name' => 'Shop',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'classMap' => [
                'User' => common\models\User::class,
            ],
            'switchIdentitySessionKey' => 'shop_user_key',
            'emailChangeStrategy' => 2,
            'administratorPermissionName' => 'admin',
            'enableFlashMessages' => false,
            'enableGdprCompliance' => true,
            'enableRegistration' => true,
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
            //'class' => 'yii\caching\MemCache',
            //'useMemcached' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'dateFormat' => 'dd-MM-yyyy',
            'timeFormat' => 'HH:mm',
            'datetimeFormat' => 'dd-MM-yyyy HH:mm',
            'timeZone' => 'Europe/Minsk',
            'defaultTimeZone' => 'Europe/Minsk',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'BYN',
        ],
        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'key',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'key',
                ],
                'error*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'key',
                ],
            ],
        ],
    ],
];