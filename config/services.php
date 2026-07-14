<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'key' => 'pk_test_51TrGMCDvDdwS2R22gxZyUwx4kn9X1TbA6cgW773WO07HzsjAp2qt90Le1pgxnE2uyBV04G57qyjLhKpF8LSB3rMi0039CeRcDI',
        'secret' => 'sk_test_51TrGMCDvDdwS2R22DDb1KHsg7gHKC1iutsGAMu5fQuAVQLXven0R1LFPI1pC08fg4IszA78xbvuwtuW2tBIrI4SK00CJODJXxl',
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

];
