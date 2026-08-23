<?php

use Spatie\Health\Notifications\CheckFailedNotification;
use Spatie\Health\Notifications\Notifiable;
use Spatie\Health\ResultStores\CacheHealthResultStore;

return [
    'result_stores' => [
        CacheHealthResultStore::class => [
            'store' => env('HEALTH_CACHE_STORE', 'file'),
        ],
    ],

    'notifications' => [
        'enabled' => false,

        'notifications' => [
            CheckFailedNotification::class => ['mail'],
        ],

        'notifiable' => Notifiable::class,

        'throttle_notifications_for_minutes' => 60,
        'throttle_notifications_key' => 'health:latestNotificationSentAt:',
        'only_on_failure' => false,

        'mail' => [
            'to' => env('HEALTH_NOTIFICATION_EMAIL', 'your@example.com'),

            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],

        'slack' => [
            'webhook_url' => env('HEALTH_SLACK_WEBHOOK_URL', ''),
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],
    ],

    'theme' => 'light',

    'json_results_failure_status' => 503,

    'secret_token' => env('HEALTH_SECRET_TOKEN'),
];
