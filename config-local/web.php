<?php
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'homeUrl' => ['site/index'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! Insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123654',
        ],
        'i18n' => [
            'translations' => [
                'mail' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US'
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mailgun.org',
                'username' => 'postmaster@mail.olarent.io',
                'password' => '07caa55c4558f13a35f7a61bec82c63e',
                'port' => '25',
                'encryption' => 'tls',
            ]
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
        'util' => [
            'class' => 'app\components\Util',
        ],
        'appLog' => [
            'class' => 'app\components\AppLogger',
            'logType' => 1,
            'logParams' => [
                1 => [
                    'logPath' => dirname(__DIR__) . '/runtime/logs/',
                    'logName' => '-activity.log',
                    'logLevel' => 3, // Take necessary value from apploger class
                    'logSocket' => '',
                    'isConsole' => false
                ],
                2 => [
                    'logPath' => dirname(__DIR__) . '/runtime/logs/',
                    'logName' => '-api.log',
                    'logLevel' => 3, // Take necessary value from apploger class
                    'logSocket' => '',
                    'isConsole' => false
                ]
            ]
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // User
                'POST api/v1/user' => 'v1/user/create',
                'GET api/v1/user/<id:\d+>' => 'v1/user/view',
                'PUT api/v1/user/<id:\d+>' => 'v1/user/update',
                'DELETE api/v1/user/<id:\d+>' => 'v1/user/delete',
                'POST api/v1/user/authenticate' => 'v1/user/authenticate',
                'GET api/v1/user/search' => 'v1/user/search',
                'POST api/v1/user/forgot-password' => 'v1/user/forgot-password',
                'POST api/v1/user/reset-password' => 'v1/user/reset-password',

                // Permission
                'POST api/v1/permission' => 'v1/permission/create',
                'GET api/v1/permission/search' => 'v1/permission/search',
                'GET api/v1/permission/<name:[a-zA-Z0-9.]+>' => 'v1/permission/view',
                'PUT api/v1/permission/<name:[a-zA-Z0-9.]+>' => 'v1/permission/update',
                'DELETE api/v1/permission/<name:[a-zA-Z0-9.]+>' => 'v1/permission/delete',

                // Role
                'POST api/v1/role' => 'v1/role/create',
                'GET api/v1/role/search' => 'v1/role/search',
                'GET api/v1/role/<name:[a-zA-Z0-9.]+>' => 'v1/role/view',
                'PUT api/v1/role/<name:[a-zA-Z0-9.]+>' => 'v1/role/update',
                'DELETE api/v1/role/<name:[a-zA-Z0-9.]+>' => 'v1/role/delete',

                // Video Activity
                'POST api/v1/video-activity' => 'v1/video-activity/create',
                'GET api/v1/video-activity/search' => 'v1/video-activity/search',

            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\api\v1\v1',
        ],
    ],
    'aliases' => [
        '@defaultTheme' => '/themes/default/',
        '@api' => '@app/modules/api',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    $config['components']['urlManager']['showScriptName'] = true;
}

return $config;
