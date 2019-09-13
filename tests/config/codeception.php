<?php

use yii\helpers\ArrayHelper;

if (is_dir(YII_APP_BASE_PATH . '/frontend')) {
    $db = ArrayHelper::merge(
        require YII_APP_BASE_PATH . '/common/config/main-local.php',
        require YII_APP_BASE_PATH . '/common/config/test-local.php',
        require YII_APP_BASE_PATH . '/frontend/config/main.php'
    );
    $basePath = YII_APP_BASE_PATH . '/frontend';
    $aliases = [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@common' => YII_APP_BASE_PATH . '/common',
        '@frontend' => YII_APP_BASE_PATH . '/frontend',
        '@aka03/comments' => YII_APP_BASE_PATH . '/vendor/aka03/yii2-comments'
    ];
    $assetsPath = YII_APP_BASE_PATH . '/frontend/web/assets';
    $controllerNamespace = 'frontend\controllers';
} else {
    $db = require __DIR__ . '/../config/test.php';
    $basePath = YII_APP_BASE_PATH;
    $aliases = [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@app' => YII_APP_BASE_PATH,
        '@aka03/comments' => YII_APP_BASE_PATH . '/vendor/aka03/yii2-comments'
    ];
    $assetsPath = YII_APP_BASE_PATH . '/web/assets';
    $controllerNamespace = 'app\controllers';
}

return [
    'id' => 'comments-tests',
    'language' => 'en',
    'basePath' => $basePath,
    'controllerNamespace' => $controllerNamespace,
    'aliases' => $aliases,
    'vendorPath' => YII_APP_BASE_PATH . '/vendor',
    'modules' => [
        'testPage' => [
            'class' => 'aka03\comments\modules\testPage\Module',
        ],
    ],
    'components' => [
        'db' => $db['components']['db'],
        'assetManager' => [
            'basePath' => $assetsPath,
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                'test-page' => 'testPage/default',
                'test-page/<action>' => 'testPage/default/<action>'
            ]
        ],
        'user' => $db['components']['user'],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'i18n' => [
            'translations' => [
                'comment*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath'       => '@aka03/comments/messages',
                    'fileMap'        => [
                        'comment' => 'comment.php',
                    ],
                ],
            ],
        ],
    ],
];
