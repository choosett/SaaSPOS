<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'database'), // ✅ Use database storage

    'lifetime' => 120,  // ✅ Keep session active for 2 hours

    'expire_on_close' => false, // ✅ Ensures session persists even after browser is closed

    'encrypt' => false, // ✅ No need to encrypt for performance

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION', null),

    'table' => 'sessions', // ✅ Ensure correct database table

    'store' => env('SESSION_STORE', null),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    'path' => '/',

    'domain' => env('SESSION_DOMAIN', '127.0.0.1'), // ✅ Important for local development

    'secure' => false, // ✅ Set to "true" in production

    'http_only' => true, // ✅ Protect against JavaScript attacks

    'same_site' => 'lax', // ✅ Prevents CSRF issues

    'partitioned' => false,
];
