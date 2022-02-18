<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // This exposes the route /ui-translations
    'load-routes' => false,
    'routes-path' => 'ui-translations',
    'routes-middleware' => ['web', 'auth'],
    'locales' => ['en', 'nl'],
];
