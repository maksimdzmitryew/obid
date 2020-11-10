<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mail' => [
        'from' 	=> env('MAIL_FROM_ADDRESS'),
        'name' 	=> env('MAIL_FROM_NAME'),
        'to' 	=> env('MAIL_TO_ADDRESS'),
        'me' 	=> env('MAIL_TO_NAME'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'recaptcha' => [
            'key' => env('GOOGLE_RECAPTCHA_V2_SITE_KEY'),
            'secret' => env('GOOGLE_RECAPTCHA_V2_SECRET'),
        ],
        'map' => [
            'key' => env('GOOGLE_MAPS_API_KEY'),
        ],
    ],

    'analysis' => [
        'google' => [
            'tag' => env('ANALYSIS_GOOGLE_TAG'),
            'analytics' => env('ANALYSIS_GOOGLE_ANALYTICS'),
        ],
    ],

];
