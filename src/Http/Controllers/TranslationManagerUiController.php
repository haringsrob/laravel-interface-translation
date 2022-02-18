<?php

namespace Haringsrob\LaravelInterfaceTranslation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class TranslationManagerUiController extends Controller
{
    public function index(): View
    {
        return view('laravel-interface-translation::ui.translation-ui');
    }
}
