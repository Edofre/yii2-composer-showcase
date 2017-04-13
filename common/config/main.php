<?php
return [
    'name'       => 'Yii2 Composer Showcase',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'i18n'        => [
            'translations' => [
                '*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath'       => '@common/messages',
                ],
            ],
        ],
        'authManager' => [
            'class'        => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter'   => [
            'nullDisplay'    => '',
            'currencyCode'   => 'EUR',
            'dateFormat'     => 'php: d-m-yy',
            'datetimeFormat' => 'php: d-m-yy H:i:s',
            'timeFormat'     => 'H:mm:ss',
            'booleanFormat'  => ['Nee', 'Ja'],
        ],
        'urlManager'  => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
        'user'        => [
            'identityClass'   => 'common\models\User',
            'class'           => 'common\components\web\User',
            'enableAutoLogin' => true,
            'loginUrl'        => ['user/login'],
        ],
    ],
];
