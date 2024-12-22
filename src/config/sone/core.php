<?php

return [
    'prefix_web' => env('SONE_CORE_ADMIN_PREFIX_WEB', 'admin'),
    'prefix_api' => env('SONE_CORE_ADMIN_PREFIX_API', 'api/core'),

    /*
    |--------------------------------------------------------------------------
    | Theme (User Interface)
    |--------------------------------------------------------------------------
    */
    // Change the view namespace in order to load a different theme than the one Backpack provides.
    // You can create child themes yourself, by creating a view folder anywhere in your resources/views
    // and choosing that view_namespace instead of the default one. Backpack will load a file from there
    // if it exists, otherwise it will load it from the fallback namespace.

    'view_namespace'          => 'sone::',
    'view_namespace_fallback' => 'sone::',
];
