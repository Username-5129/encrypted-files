<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class LibreTranslateService
{
    protected $client;
    protected $endpoint = 'https://libretranslate.com/translate';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function translate(string $text, string $targetLang, string $sourceLang = 'en'): string
    {
        if ($targetLang === $sourceLang) {
            return $text;
        }

        $cacheKey = 'translation_' . md5($text . '_' . $targetLang);

        return Cache::remember($cacheKey, now()->addDay(), function () use ($text, $targetLang, $sourceLang) {
            try {
                $response = $this->client->post($this->endpoint, [
                    'json' => [
                        'q' => $text,
                        'source' => $sourceLang,
                        'target' => $targetLang,
                        'format' => 'text',
                    ],
                    'timeout' => 5,
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                return $data['translatedText'] ?? $text;
            } catch (\Exception $e) {
                return $text;
            }
        });
    }
}
