<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Facades;

use Illuminate\Support\Facades\Facade;
use PascalKleindienst\LaravelTextToSpeech\EngineManager;

/**
 * @see EngineManager
 */
final class TextToSpeech extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EngineManager::class;
    }
}
