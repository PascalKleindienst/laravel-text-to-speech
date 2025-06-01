<?php

declare(strict_types=1);

use Aws\Polly\PollyClient;
use Aws\Result;
use PascalKleindienst\LaravelTextToSpeech\Engines\PollyEngine;

it('can make a new instance', function () {
    expect(PollyEngine::make())->toBeInstanceOf(PollyEngine::class);
});

it('can synthesize text', function (string $text) {
    // Setup Mocks
    $audioStream = $this->mock(stdClass::class)
        ->shouldReceive('getContents')
        ->once()
        ->andReturn($text)
        ->getMock();
    $result = $this->mock(Result::class)
        ->shouldReceive('get')
        ->once()->with('AudioStream')->andReturn($audioStream)
        ->getMock();
    $client = $this->mock(PollyClient::class)
        ->shouldReceive('synthesizeSpeech')
        ->once()
        ->andReturn($result)
        ->getMock();

    Storage::fake();

    // Test
    $engine = new PollyEngine($client);
    $speech = $engine->convert($text);

    // Assertions
    Storage::assertExists($speech->file);
    expect(Storage::get($speech->file))->toBe($text);
})->with([
    'short text' => ['Text'],
    'long text' => [str_repeat('Text', 2000)],
]);
