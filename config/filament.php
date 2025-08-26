<?php

return [
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    
    'middleware' => [
        'base' => [
            'web',
            'auth',
            \App\Http\Middleware\ForceHttps::class,
        ],
    ],
    
    'domain' => env('FILAMENT_DOMAIN'),
    'path' => env('FILAMENT_PATH', 'admin'),
    'home_url' => env('FILAMENT_HOME_URL', '/'),
    
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
    ],
    
    'assets' => [
        'disk' => env('FILAMENT_ASSETS_DISK', 'public'),
        'path' => 'filament/assets',
    ],
    
    'uploads' => [
        'disk' => env('FILAMENT_UPLOADS_DISK', 'public'),
        'path' => 'uploads',
    ],
];
