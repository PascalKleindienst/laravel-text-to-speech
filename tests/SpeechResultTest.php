<?php

use Illuminate\Support\Facades\Storage;
use PascalKleindienst\LaravelTextToSpeech\SpeechResult;

it('can be saved', function (?string $disk, string $file, string $data) {
    // Setup Fake Storage
    Storage::fake($disk);
    Storage::fake(config('text-to-speech.audio.disk'));
    Storage::disk(config('text-to-speech.audio.disk'))->put($file, $data);

    $result = new SpeechResult($file, $data);

    if ($disk) {
        $result->disk($disk);
    }

    $result->save('foo.mp3');

    Storage::disk($disk)->assertExists('foo.mp3');
    expect(Storage::disk($disk)->get('foo.mp3'))->toBe($data);
})->with([
    [null, 'foo.txt', 'Some Input'],
    ['testing', 'foo.txt', 'Some Input'],
]);
