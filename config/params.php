<?php

return [
    'productName' => 'Samurai',
    'productNameEmail' => 'Samurai video management system.',
    'copyright' => 'Copyright © ' . date('Y') . ' xxx. All Rights Reserved.',
    'telephone' => '00000',
    'allowEmpty' => true,
    'tempPath' => dirname(__DIR__) . '/runtime/temp/',
    'api' => [
        'apiKey' => 'xxx',
        'apiSecret' => 'CA41A12EA2828DBC49CDBDA88D521',
        'guestActions' => [
            // Actions those not require user access token
            'V1.User.Create',
            'V1.User.Authenticate',
            'V1.User.ForgotPassword',
            'V1.User.ResetPassword',
        ],
        // No authentication required for following actions
        'noAuth' => [

        ]
    ],
    'supportEmail' => 'xxx@samurai.io',
    'adminEmail' => 'xxx@samurai.io',
    'defaultTimeZone' => 'Europe/Paris', // Default timezone for user when not specified. Assign when creating a user.
    'logoUrlInEmail' => 'http://oxxxxcom/scfko0.jpg',
    'passwordRestUrl' => 'http://xxxxx/app/#/index',
    'emailUnsubLink' => '',
    'phpIniTimeZone' => date_default_timezone_get(),
    'mailgun' => [
        'apiEndPoint' => 'https://api.mailgun.net/v3/xxxxx/',
        'apiUsername' => 'xxxx',
        'apiPassword' => 'key-xxxx'
    ]
];
