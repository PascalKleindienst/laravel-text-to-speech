<?php

declare(strict_types=1);

return [
    'driver' => env('TEXT_TO_SPEECH_DRIVER'),
    'language' => env('TEXT_TO_SPEECH_LANGUAGE'),

    'audio' => [
        'path' => env('TEXT_TO_SPEECH_AUDIO_PATH', 'audio'),
        'format' => env('TEXT_TO_SPEECH_AUDIO_FORMAT', 'mp3'),
        'disk' => env('TEXT_TO_SPEECH_AUDIO_DISK', 'local'),
    ],

    'google' => [
        'private_key' => env('TEXT_TO_SPEECH_GOOGLE_PRIVATE_KEY'),
        'type' => env('TEXT_TO_SPEECH_GOOGLE_TYPE', 'service_account'),
        'client_email' => env('TEXT_TO_SPEECH_GOOGLE_CLIENT_EMAIL'),
        'voice' => env('TEXT_TO_SPEECH_GOOGLE_VOICE', 'de-DE-Chirp3-HD-Achernar'),
    ],

    'system' => [
        'rate' => env('TEXT_TO_SPEECH_SYSTEM_RATE', 175),
        'pitch' => env('TEXT_TO_SPEECH_SYSTEM_PITCH', 50),
        'volume' => env('TEXT_TO_SPEECH_SYSTEM_VOLUME', 100),
        'voice' => env('TEXT_TO_SPEECH_SYSTEM_VOICE', 'german-mbrola-1'),
    ],
];
