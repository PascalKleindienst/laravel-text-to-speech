<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech;

use Illuminate\Support\Facades\Storage;

final class SpeechResult
{
    private ?string $disk = null;

    public function __construct(
        public readonly string $file,
        public readonly string $input
    ) {}

    public function save(string $path): self
    {
        Storage::disk($this->disk)->put($path, Storage::disk(config('text-to-speech.audio.disk'))->get($this->file));

        return $this;
    }

    public function disk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }
}
