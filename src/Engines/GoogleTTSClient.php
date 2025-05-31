<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

use Google\ApiCore\ValidationException;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;

class GoogleTTSClient
{
    private ?TextToSpeechClient $client = null;

    /**
     * @return TextToSpeechClient
     * @throws ValidationException
     */
    public function getClient(): mixed
    {
        $this->client ??= new TextToSpeechClient([
            'credentials' => [
                'type' => config('text-to-speech.google.type', 'service_account'),
                'private_key' => config('text-to-speech.google.private_key'),
                'client_email' => config('text-to-speech.google.client_email'),
            ],
        ]);

        return $this->client;
    }
}
