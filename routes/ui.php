<?php

use Haringsrob\LaravelInterfaceTranslation\Http\Controllers\TranslationManagerUiController;

Route::get(
    config('laravel-interface-translation.routes-path'),
    [TranslationManagerUiController::class, 'index']
)->middleware(config('laravel-interface-translation.routes-middleware'));
