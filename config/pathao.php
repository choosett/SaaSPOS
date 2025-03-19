<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pathao API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is used to store Pathao API credentials securely.
    | You can switch between sandbox and production by changing
    | the `PATHAO_BASE_URL` in the `.env` file.
    |
    */

    'client_id' => env('PATHAO_CLIENT_ID'),
    'client_secret' => env('PATHAO_CLIENT_SECRET'),
    'username' => env('PATHAO_USERNAME'),
    'password' => env('PATHAO_PASSWORD'),
    'base_url' => env('PATHAO_BASE_URL', 'https://api-hermes.pathao.com'), // ✅ Updated for live
];
