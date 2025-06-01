<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use PascalKleindienst\LaravelTextToSpeech\Facades\GoogleTTS;

final class GoogleEngine extends Engine
{
    public static function make(): self
    {
        return new self();
    }

    protected function synthesize(string $text): string
    {
        $voice = new VoiceSelectionParams([
            'language_code' => $this->language ?? config('text-to-speech.language'),
            'name' => $this->voice ?? config('text-to-speech.google.voice'),
        ]);

        $response = GoogleTTS::getClient()->synthesizeSpeech(
            (new SynthesizeSpeechRequest())
                ->setInput((new SynthesisInput())->setText($text))
                ->setVoice($voice)
                ->setAudioConfig(new AudioConfig([
                    'audio_encoding' => AudioEncoding::MP3,
                ]))
        );

        return $response->getAudioContent();
    }
}
