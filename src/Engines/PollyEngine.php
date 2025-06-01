<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

use Aws\Credentials\Credentials;
use Aws\Polly\PollyClient;

use function mb_strlen;

final class PollyEngine extends Engine
{
    public function __construct(public readonly PollyClient $client) {}

    public static function make(): self
    {
        return new self(new PollyClient([
            'version' => config('text-to-speech.polly.version', 'latest'),
            'region' => config('text-to-speech.polly.region', 'us-east-1'),
            'credentials' => new Credentials(
                config('text-to-speech.polly.key'),
                config('text-to-speech.polly.secret'),
                config('text-to-speech.polly.token'),
            ),
        ]));
    }

    public function synthesize(string $text): ?string
    {
        $chunks = [$text];

        if ($this->isTooLong($text)) {
            $chunks = explode("\n", wordwrap($text, 2000));
        }

        $arguments = [
            'LanguageCode' => $this->language ?? config('text-to-speech.language'),
            'OutputFormat' => config('text-to-speech.polly.format', 'mp3'),
            'VoiceId' => $this->voice ?? config('text-to-speech.polly.voice'),
            'Engine' => config('text-to-speech.polly.engine', 'standard'),
            'TextType' => config('text-to-speech.polly.text_type', 'text'),
            // TODO: Speech Marks
        ];

        $result = '';
        foreach ($chunks as $chunk) {
            $arguments['Text'] = $chunk;
            $response = $this->client->synthesizeSpeech($arguments);

            // TODO: Handle Speech Marks
            $result .= $response->get('AudioStream')?->getContents();
        }

        return $result;
    }

    private function isTooLong(string $text): bool
    {
        return mb_strlen($text) > 2000;
    }
}
