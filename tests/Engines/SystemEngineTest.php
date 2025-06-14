<?php

declare(strict_types=1);

use PascalKleindienst\LaravelTextToSpeech\Engines\SystemEngine;
use PascalKleindienst\LaravelTextToSpeech\Exceptions\EngineNotSupportedException;
use PascalKleindienst\LaravelTextToSpeech\Facades\TextToSpeech;

it('fails when the engine is not supported', function () {
    expect(static fn () => TextToSpeech::engine('system'))->toThrow(EngineNotSupportedException::class);
})->skip(is_executable(exec('which espeak-ng')));

it('can create the system engine', function () {
    expect(TextToSpeech::engine('system'))->toBeInstanceOf(SystemEngine::class);
})->skip(! is_executable(exec('which espeak-ng')), 'system driver "espeak-ng" is not installed');

it('can synthesize text', function () {
    \Illuminate\Support\Facades\Storage::fake();
    $result = TextToSpeech::engine('system')->convert('test');
    Storage::assertExists($result->file);
    expect(Storage::fileSize($result->file))->toBeGreaterThan(0);
})->skip(! is_executable(exec('which espeak-ng')), 'system driver "espeak-ng" is not installed');

it('fails when there is an error with espeak-ng', function () {
    $result = Process::result('failed', 'error', 1);
    Process::shouldReceive('run')->once()->andReturn($result);
    expect(static fn () => TextToSpeech::engine('system')->convert('test'))->toThrow(RuntimeException::class);
})->skip(! is_executable(exec('which espeak-ng')), 'system driver "espeak-ng" is not installed');
