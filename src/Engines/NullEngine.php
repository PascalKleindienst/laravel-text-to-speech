<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Engines;

final class NullEngine extends Engine
{
    protected function synthesize(string $text): ?string
    {
        return null;
    }
}
