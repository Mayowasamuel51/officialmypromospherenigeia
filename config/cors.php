<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:4000',
        'https://www.mypromosphere.com',
        'https://mypromopshere-nigeria.vercel.app',
        'https://www.mypromosphere.com/learning'
    ],

    // 'allowed_headers' => [':authority:', ':method:', ':path:', ':scheme:'],

    'allowed_origins_patterns' => [],
    // 
    // 'allowed_headers' => ['POST', 'GET', 'DELETE', 'PUT', '*'],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept', 'Origin', 'X-CSRF-TOKEN', '*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
