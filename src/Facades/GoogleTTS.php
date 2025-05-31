<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Facades;

use Illuminate\Support\Facades\Facade;
use PascalKleindienst\LaravelTextToSpeech\Engines\GoogleTTSClient;

/**
 * @see GoogleTTSClient
 */
final class GoogleTTS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GoogleTTSClient::class;
    }
}
