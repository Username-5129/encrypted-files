<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LibreTranslateService;

class LanguageController extends Controller
{
    protected $translationService;

    public function __construct(LibreTranslateService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'target_lang' => 'required|string|size:2',
        ]);

        $text = $request->input('text');
        $targetLang = $request->input('target_lang');

        $translated = $this->translationService->translate($text, $targetLang);

        return response()->json([
            'original' => $text,
            'translated' => $translated,
            'target_lang' => $targetLang,
        ]);
    }
}
