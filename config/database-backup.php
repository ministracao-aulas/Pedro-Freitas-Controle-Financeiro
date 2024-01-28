<?php

return [
    'notifiers' => [
        'email' => array_filter(
            explode(';', strval(env('DB_BACKUP_EMAIL_DESTINATIONS'))),
            fn ($item) => filter_var($item, FILTER_VALIDATE_EMAIL),
        ),
        'webhooks' => array_filter(
            explode(';', strval(env('DB_BACKUP_WEBHOOKS_DESTINATIONS'))),
            fn ($item) => filter_var(
                $item,
                FILTER_VALIDATE_URL
            ),
        ),
    ],
];
