<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;


class LanguageController extends Controller
{

    public function switchLang($lang)
    {
        if (array_key_exists($lang, config('languages'))) {
            Session::put('applocale', $lang);

            if (Auth::check()) {
                $language = Language::where('code', $lang)->first();
                if ($language) {
                    $user = Auth::user();
                    $user->language_id = $language->id;
                    $user->save();
                } 
            }
        }

        return redirect()->back();
    }
}