<?php

return [
    'default_locale' => 'en',
    'fallback_locale' => 'en',
    'available_locales' => [
        'en',
        'ru',
        'de'
    ],
    'translation_paths' => [
        'app' => resource_path('lang'),
        'package' => base_path('vendor/sonecms/sone-core/src/resources/lang'),
    ],
];
