<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
//    'language' => 'it-IT',
    'components' => [
//        'cookieValidationKey' => 'jfsbkjsbfdskjgfdskjbgfsdhjgfajds',
        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'agentend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'clients*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'UploadFile' => [
            'class' => 'common\components\UploadFile',
        ],
        'mails' => [
            'class' => 'common\components\SendMail',
        ],
        'notificationManager' => [
            'class' => 'common\components\NotificationManager'
        ],
        'ApiManager' => [
            'class' => 'common\components\ApiManager'
        ],
        'CommonRequest' => [
            'class' => 'common\components\CommonRequest'
        ],
    ],
];
