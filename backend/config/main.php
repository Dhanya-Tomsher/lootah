<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'en', // Set the language here
//    'bootstrap' => ['log'],
    'bootstrap' => [
        'log',
        //component for switching identities
        'common\components\IdentitySwitcher'
    ],
    'modules' => [
        'orders' => [
            'class' => 'backend\modules\orders\orders',
        ],
    ],
    'components' => [
        'mailer ' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@backend/mail',
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'support@tomsher.com',
//                'username' => 'support@tomsher.com',
//                'password' => '&dYR1KddjksH',
//                'enableSwiftMailerLogging' => true,
//                'port' => '465',
//            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'support@tomsher.com',
                'password' => 'tomsher123',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'ApiManager' => [
            'class' => 'common\components\ApiManager'
        ],
        'UploadFile' => [
            'class' => 'common\components\UploadFile',
        ],
        'notificationManager' => [
            'class' => 'common\components\NotificationManager'
        ],
        'DmsapiManager' => [
            'class' => 'common\components\DmsapiManager'
        ],
        'ErrorCode' => [
            'class' => 'common\components\ErrorCode'
        ],
        'CommonRequest' => [
            'class' => 'common\components\CommonRequest'
        ],
//        'IdentitySwitcher' => [
//            'class' => 'common\components\IdentitySwitcher'
//        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'class' => 'common\components\Request',
            'web' => '/backend/web',
            'adminUrl' => '/admin',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
        ],
        'image' => [
            'class' => 'mervick\\image\\Component',
            'driver' => 'mervick\\image\\drivers\\Imagick',
        ],
        'user' => [
            'identityClass' => 'common\models\UserAdmin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
//        'agent' => [
//            'identityClass' => 'common\models\Users',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-agent', 'httpOnly' => true],
//        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            ],
        ],
    ],
    'as beforeRequest' =>
    [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
