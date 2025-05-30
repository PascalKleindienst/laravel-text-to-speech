<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use PascalKleindienst\LaravelTextToSpeech\LaravelTextToSpeechServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'PascalKleindienst\\LaravelTextToSpeech\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function defineEnvironment($app)
    {
        config()->set('database.default', 'testing');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelTextToSpeechServiceProvider::class,
        ];
    }
}
