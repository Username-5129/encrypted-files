<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Services\LibreTranslateService;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request, string $locale): RedirectResponse
    {
        $availableLocales = ['en', 'lv'];
        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
            Session::put('applocale', $locale);
        }
        $redirectTo = url()->previous() ?: route('home');
        return redirect($redirectTo);
    }
}
