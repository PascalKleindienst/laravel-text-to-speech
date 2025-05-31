<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

use Illuminate\Support\Facades\Process;
use RuntimeException;

final class SystemEngine extends Engine
{
    protected function synthesize(string $text): ?string
    {
        $config = [
            'rate' => config('text-to-speech.system.rate'),
            'pitch' => config('text-to-speech.system.pitch'),
            'volume' => config('text-to-speech.system.volume'),
            'voice' => $this->voice ?? config('text-to-speech.system.voice'),
        ];

        $filepath = '/tmp/'.md5($text).'.wav';
        $output = Process::run(['espeak-ng', '-a', $config['volume'], '-p', $config['pitch'], '-s', $config['rate'], '-v', $config['voice'], $text, '-w', $filepath]);

        if ($output->failed()) {
            throw new RuntimeException($output->errorOutput());
        }

        return file_get_contents($filepath) ?: null;
    }
}
