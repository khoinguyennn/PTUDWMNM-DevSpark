<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayOS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your PayOS settings. PayOS is a payment gateway
    | that allows you to accept payments from customers.
    |
    */

    'client_id' => env('PAYOS_CLIENT_ID', ''),
    'api_key' => env('PAYOS_API_KEY', ''),
    'checksum_key' => env('PAYOS_CHECKSUM_KEY', ''),
    'partner_code' => env('PAYOS_PARTNER_CODE', null), // Optional

    /*
    |--------------------------------------------------------------------------
    | PayOS URLs
    |--------------------------------------------------------------------------
    |
    | These URLs are used by PayOS for redirecting users after payment
    |
    */
    'return_url' => env('PAYOS_RETURN_URL', env('APP_URL') . '/payment/success'),
    'cancel_url' => env('PAYOS_CANCEL_URL', env('APP_URL') . '/payment/cancel'),
    'webhook_url' => env('PAYOS_WEBHOOK_URL', env('APP_URL') . '/payment/webhook'),

    /*
    |--------------------------------------------------------------------------
    | PayOS Environment
    |--------------------------------------------------------------------------
    |
    | This option determines whether PayOS is in sandbox mode or live mode
    |
    */
    'sandbox' => env('PAYOS_SANDBOX', true),
];
