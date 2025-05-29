<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class LaravelTextToSpeechServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-text-to-speech')
            ->hasConfigFile();
        // ->hasMigration('create_laravel_text_to_speech_table')
        // ->hasCommand(LaravelTextToSpeechCommand::class);
    }
}
