<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

use Illuminate\Support\Facades\Storage;
use PascalKleindienst\LaravelTextToSpeech\Source;
use PascalKleindienst\LaravelTextToSpeech\SpeechResult;

abstract class Engine
{
    protected Source $source = Source::Text;

    protected ?string $language = null;

    protected ?string $voice = null;

    /**
     * Synthesizes the given text into speech.
     */
    abstract protected function synthesize(string $text): ?string;

    public function convert(string $data): SpeechResult
    {
        $text = $this->getTextFromSource($data);

        // TODO: check limit
        $result = $this->synthesize($text);

        $path = $this->storeResult($text, $result);

        return new SpeechResult($path, $text);
    }

    public function getTextFromSource(string $data): string
    {
        if ($this->source === Source::File && is_readable($data)) {
            return file_get_contents($data);
        }

        return $data;
    }

    public function from(Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function language(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function voice(string $voice): self
    {
        $this->voice = $voice;

        return $this;
    }

    protected function storeResult(string $text, ?string $data): string
    {
        // Get Path
        $filename = $this->getDefaultPath().DIRECTORY_SEPARATOR.$this->getDefaultFilename($text, $data);

        if (! $this->hasExtension($filename)) {
            $filename .= '.'.$this->getExtension();
        }

        Storage::disk(config('text-to-speech.audio.disk'))->put($filename, $data ?? '');

        return $filename;
    }

    protected function getDefaultPath(): string
    {
        return config('text-to-speech.audio.path', 'audio');
    }

    protected function getDefaultFilename(string $text, ?string $data): string
    {
        return md5($text);
    }

    protected function hasExtension(string $filename): bool
    {
        return (bool) pathinfo($filename, PATHINFO_EXTENSION);
    }

    protected function getExtension(): string
    {
        return config('text-to-speech.audio.format', 'mp3');
    }
}
