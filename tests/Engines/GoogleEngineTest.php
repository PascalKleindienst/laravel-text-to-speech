<?php

use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse;
use PascalKleindienst\LaravelTextToSpeech\Engines\GoogleEngine;
use PascalKleindienst\LaravelTextToSpeech\Facades\GoogleTTS;
use PascalKleindienst\LaravelTextToSpeech\Facades\TextToSpeech;
use PascalKleindienst\LaravelTextToSpeech\SpeechResult;

it('can create the system engine', function () {
    expect(TextToSpeech::engine('google'))->toBeInstanceOf(GoogleEngine::class);
});

it('can synthesize text', function () {
    $mockResponse = $this->mock(SynthesizeSpeechResponse::class)
        ->shouldReceive('getAudioContent')
        ->andReturn('test')
        ->getMock();

    $mockClient = $this->mock(stdClass::class)
        ->shouldReceive('synthesizeSpeech')
        ->andReturn($mockResponse)
        ->getMock();

    GoogleTTS::shouldReceive('getClient')->andReturn($mockClient);

    $engine = new GoogleEngine();

    expect($engine->convert('test'))->toBeInstanceOf(SpeechResult::class);
});
