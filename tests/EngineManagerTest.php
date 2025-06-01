<?php

declare(strict_types=1);

use PascalKleindienst\LaravelTextToSpeech\EngineManager;
use PascalKleindienst\LaravelTextToSpeech\Engines\Engine;
use PascalKleindienst\LaravelTextToSpeech\Engines\GoogleEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\NullEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\PollyEngine;
use PascalKleindienst\LaravelTextToSpeech\Engines\SystemEngine;
use PascalKleindienst\LaravelTextToSpeech\Exceptions\EngineNotSupportedException;

it('has a default driver', function () {
    expect(app(EngineManager::class)->getDefaultDriver())->toBe('null');
});

it('can create an engine', function () {
    expect(app(EngineManager::class)->engine('null'))->toBeInstanceOf(Engine::class);
});

it('can create a null engine', function () {
    expect(app(EngineManager::class)->createNullDriver())->toBeInstanceOf(NullEngine::class);
});

it('can create a system engine', function () {
    expect(app(EngineManager::class)->createSystemDriver())->toBeInstanceOf(SystemEngine::class);
})->throwsIf(! is_executable(exec('which espeak-ng')), EngineNotSupportedException::class, 'system driver "espeak-ng" is not installed');

it('can create a google engine', function () {
    expect(app(EngineManager::class)->createGoogleDriver())->toBeInstanceOf(GoogleEngine::class);
});

it('can create a amazon engine', function () {
    expect(app(EngineManager::class)->createPollyDriver())->toBeInstanceOf(PollyEngine::class);
});

it('can be extended', function () {
    $customEngine = new class extends Engine
    {
        public function synthesize(string $text): string
        {
            return $text;
        }
    };

    app()->resolving(
        EngineManager::class,
        fn (EngineManager $manager) => $manager->extend('test', fn () => new $customEngine())
    );

    expect(app(EngineManager::class)->engine('test'))->toBeInstanceOf($customEngine::class);
});
