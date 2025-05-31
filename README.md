# 🎵 Laravel Text To Speech

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pascalkleindienst/laravel-text-to-speech.svg?style=flat-square)](https://packagist.org/packages/pascalkleindienst/laravel-text-to-speech)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pascalkleindienst/laravel-text-to-speech/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pascalkleindienst/laravel-text-to-speech/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pascalkleindienst/laravel-text-to-speech/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pascalkleindienst/laravel-text-to-speech/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pascalkleindienst/laravel-text-to-speech.svg?style=flat-square)](https://packagist.org/packages/pascalkleindienst/laravel-text-to-speech)

A simple and elegant Laravel package that converts text to speech using various TTS engines. Easily integrate voice
synthesis into your Laravel applications with support for multiple languages, voices, and audio formats.

### Features

- 🎤 Multiple TTS engine support
- 🌍 Multi-language compatibility
- 🔊 Customizable voice options
- ⚡️ Simple, fluent API
- 🚀 Easy Laravel integration

Perfect for creating accessible applications, voice notifications, audiobooks, or any project requiring speech
synthesis.

## 📖️ Installation

You can install the package via composer:

```bash
composer require pascalkleindienst/laravel-text-to-speech
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-text-to-speech-config"
```

This is the contents of the published config file:

```php
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
```

### Driver Prequisites

#### System Driver

When using the system driver, you need to install the following packages:

- [espeak-ng](https://espeak-ng.org/)

#### Google Driver

When using the google driver, you need to install the following packages:

```bash
composer require google/cloud-text-to-speech"
```

## 💻 Usage

```php
use PascalKleindienst\LaravelTextToSpeech\Facades\TextToSpeech;
use PascalKleindienst\LaravelTextToSpeech\Source;

// The text is converted to speech and stored in a file (configured in the "audio" config).
TextToSpeech::convert('Hello World!'); 

// The text is converted to speech and additionallystored in the given file.
TextToSpeech::convert('Hello World!')->save('path/to/file.mp3'); 

// Store the converted text on a different disk
TextToSpeech::from(Source::File)->disk('s3')->convert('path/to/file.txt');

// convert text from a file
TextToSpeech::from(Source::File)->convert('path/to/file.txt');

/**
 * Change the language and/or voice used for the speech. 
 * NOTE: 
 *   This will overwrite the language and voice settings in the config file.
 *   Also the format for the language might be different for each engine, e.g. de vs de-DE
 */
TextToSpeech::language('de-DE')->voice('male')->convert('Hallo Welt!');

// Use the system engine to convert text to speech, needs espeak-ng to be installed
TextToSpeech::engine('system')->convert('Hello System Engine!');

// Use the Google engine to convert text to speech, needs google cloud sdk to be installed
TextToSpeech::engine('google')->convert('Hello Google Engine!');
```

## 👨‍🔬 Testing

```bash
composer test
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Pascal Kleindienst](https://github.com/PascalKleindienst)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
