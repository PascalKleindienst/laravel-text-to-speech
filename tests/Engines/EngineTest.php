<?php

declare(strict_types=1);

use PascalKleindienst\LaravelTextToSpeech\EngineManager;
use PascalKleindienst\LaravelTextToSpeech\Engines\Engine;
use PascalKleindienst\LaravelTextToSpeech\Source;
use PascalKleindienst\LaravelTextToSpeech\SpeechResult;

beforeEach(function () {
    $this->testEngine = new class extends Engine
    {
        public function getSource(): Source
        {
            return $this->source;
        }

        public function getLanguage(): ?string
        {
            return $this->language;
        }

        public function getVoice(): ?string
        {
            return $this->voice;
        }

        protected function synthesize(string $text): ?string
        {
            return 'got called';
        }
    };
});

it('can create an engine', function () {
    $manager = (new EngineManager(app()))->extend('test', fn () => $this->testEngine);

    expect($manager->engine('test'))->toBe($this->testEngine);
});

it('can convert text to a speech result', function () {
    $result = $this->testEngine->convert('foo');

    expect($result)->toBeInstanceOf(SpeechResult::class)
        ->and($result->input)->toBe('foo')
        ->and(Storage::get($result->file))->toBe('got called');
});

it('can get the text from a source', function (Source $source, string $data, string $result) {
    expect($this->testEngine->from($source)->getTextFromSource($data))->toBe($result);
})->with([
    [Source::Text, 'foo', 'foo'],
    [Source::File, __DIR__.'/../fixtures/test.txt', 'Hello World!
'],
]);

it('can get the file path', function () {
    expect($this->testEngine->getFilePath('foo'))->toBe(
        config('text-to-speech.audio.path', 'audio').DIRECTORY_SEPARATOR.md5('foo').'.mp3'
    );
});

it('can get the full file path', function () {
    expect($this->testEngine->getFullPath('foo'))->toBe(
        Storage::disk(config('text-to-speech.audio.disk'))->path(config('text-to-speech.audio.path', 'audio').DIRECTORY_SEPARATOR.md5('foo').'.mp3')
    );
});

it('can set the voice', function () {
    expect($this->testEngine->voice('John Doe')->getVoice())->toBe('John Doe');
});
it('can set the language', function () {
    expect($this->testEngine->language('de-DE')->getLanguage())->toBe('de-DE');
});
