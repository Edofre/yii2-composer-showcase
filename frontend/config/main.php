<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'omniKassa'    => [
            'class'                => '\edofre\omnikassa\OmniKassa',
            'automaticResponse'    => false,
            'currencyCode'         => '978',
            'customerLanguage'     => 'NL',
            'interfaceVersion'     => 'HP_1.0',
            'keyVersion'           => '1',
            'merchantId'           => '002020000000001',
            'paymentMeanBrandList' => 'IDEAL,VISA,MASTERCARD,MAESTRO',
            'secretKey'            => '002020000000001_KEY1',
            'testMode'             => true,
            'url'                  => 'https://payment-webinit.simu.omnikassa.rabobank.nl/paymentServlet',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key'      => 'AIzaSyB35TM_Fw7yUuGU3VFm8Jkrfq6SjddLjWY',
                        'language' => 'nl',
                        'version'  => '3.1.18',
                    ],
                ],
            ],
        ],
    ],
    'params'              => $params,
];
