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

    'stream' => [
        'key' => env('STREAM_API_KEY'),
        'secret' => env('STREAM_API_SECRET'),
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'bot_admin_token' => env('GROUP_ADMIN_BOT_TOKEN'),
        'admin_chat_id' => env('GROUP_ADMIN_CHAT_ID'),
        'staff_chat_id' => env('GROUP_STAFF_CHAT_ID'),
        'staff_group_invite' => env('TELEGRAM_STAFF_GROUP_INVITE'),
        'admin_group_invite' => env('TELEGRAM_ADMIN_GROUP_INVITE'),
    ],

];
