<?php

use PascalKleindienst\LaravelTextToSpeech\Engines\NullEngine;
use PascalKleindienst\LaravelTextToSpeech\Facades\TextToSpeech;
use PascalKleindienst\LaravelTextToSpeech\SpeechResult;

it('can create the null engine', function () {
    expect(TextToSpeech::engine('null'))->toBeInstanceOf(NullEngine::class);
});

it('can synthesize text', function () {
    $result = TextToSpeech::engine('null')->convert('test');

    expect($result)->toBeInstanceOf(SpeechResult::class)
        ->and(Storage::get($result->file))->toBeEmpty();
});
