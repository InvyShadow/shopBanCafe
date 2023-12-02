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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '1728930110952229',
        'client_secret' => '0b2e694691b0bef656924f42af047908',
        'redirect' => 'http://localhost/shopBanCafe/admin/callback'
    ],

    'google' => [
        'client_id' => '558238156402-guens5h6u5phkrt7s8m4t4ltu6jhmk2n.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/shopBanCafe/google/callback'
    ],

];
