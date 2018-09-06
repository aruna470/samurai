<?php

return [
    'productName' => 'Samurai',
    'productNameEmail' => 'Samurai video management system.',
    'copyright' => 'Copyright © ' . date('Y') . ' Samurai. All Rights Reserved.',
    'telephone' => '+33 6 10 88 20 49',
    'allowEmpty' => true,
    'tempPath' => dirname(__DIR__) . '/runtime/temp/',
    'api' => [
        'apiKey' => '2BAAFD2BE944AAA5B21BCBDF99F6E',
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
    'supportEmail' => 'support@samurai.io',
    'adminEmail' => 'support@samurai.io',
    'defaultTimeZone' => 'Europe/Paris', // Default timezone for user when not specified. Assign when creating a user.
    'logoUrlInEmail' => 'http://oi68.tinypic.com/scfko0.jpg',
    'passwordRestUrl' => 'http://staging.olarent.io/app/#/index',
    'emailUnsubLink' => '',
    'phpIniTimeZone' => date_default_timezone_get(),
    'mailgun' => [
        'apiEndPoint' => 'https://api.mailgun.net/v3/mail.olarent.io/',
        'apiUsername' => 'api',
        'apiPassword' => 'key-ea558bc0afe197ed298e908881a3f9eb'
    ]
];
