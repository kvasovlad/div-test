<?php

use App\Services\FileMailService;
use App\Services\NullMailService;

return [
    'default' => env('EMAIL_SERVICE', 'file'),

    'services' => [
        'file' => FileMailService::class,
        'null' => NullMailService::class,
    ],

    'storage_path' => storage_path('app/emails'),
];
