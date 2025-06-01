<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech;

use Aws\Polly\PollyClient;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;
use Illuminate\Support\Manager;
use PascalKleindienst\LaravelTextToSpeech\Engines\Engine;
use PascalKleindienst\LaravelTextToSpeech\Engines\GoogleEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\NullEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\PollyEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\SystemEngine;
use PascalKleindienst\LaravelTextToSpeech\Exceptions\EngineNotSupportedException;

/**
 * @mixin Engine
 */
final class EngineManager extends Manager
{
    /**
     * @template T of string
     *
     * @param  T  $name
     * @return (T is 'null' ? NullEngine : Engine)
     */
    public function engine(string $name): Engine
    {
        return $this->driver($name);
    }

    public function getDefaultDriver(): string
    {
        return config('text-to-speech.driver', 'null') ?? 'null';
    }

    /**
     * @throws EngineNotSupportedException
     */
    public function createGoogleDriver(): GoogleEngine
    {
        $this->ensureGoogleSdkIsInstalled();

        return GoogleEngine::make();
    }

    /**
     * @throws EngineNotSupportedException
     */
    public function createPollyDriver(): PollyEngine
    {
        $this->ensureAwsSdkIsInstalled();

        return PollyEngine::make();
    }

    /**
     * @throws EngineNotSupportedException
     */
    public function createSystemDriver(): SystemEngine
    {
        $this->ensureSystemDriverIsInstalled();

        return new SystemEngine();
    }

    public function createNullDriver(): NullEngine
    {
        return new NullEngine();
    }

    /**
     * @throws EngineNotSupportedException
     */
    private function ensureGoogleSdkIsInstalled(): void
    {
        if (! class_exists(TextToSpeechClient::class)) {
            throw new EngineNotSupportedException('Please install the suggested Google SDK: google/cloud-text-to-speech');
        }
    }

    /**
     * @throws EngineNotSupportedException
     */
    private function ensureAwsSdkIsInstalled(): void
    {
        if (! class_exists(PollyClient::class)) {
            throw new EngineNotSupportedException('Please install the suggested AWS SDK: aws/aws-sdk-php');
        }
    }

    /**
     * @throws EngineNotSupportedException
     */
    private function ensureSystemDriverIsInstalled(): void
    {
        $espeakNg = exec('which espeak-ng');
        if ($espeakNg === false || ! is_executable($espeakNg)) {
            throw new EngineNotSupportedException('Please install the suggessted system driver: espeak-ng');
        }
    }
}
