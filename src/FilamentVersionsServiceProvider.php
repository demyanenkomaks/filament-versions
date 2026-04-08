<?php

namespace Maksde\FilamentVersions;

use Illuminate\Support\ServiceProvider;
use Maksde\FilamentVersions\Support\BuildsVersionStats;

class FilamentVersionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-versions.php', 'filament-versions');

        $this->app->singleton(FilamentVersionsPlugin::class, fn (): FilamentVersionsPlugin => new FilamentVersionsPlugin);
        $this->app->singleton(BuildsVersionStats::class);
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-versions');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => lang_path('vendor/filament-versions'),
            ], 'filament-versions-translations');

            $this->publishes([
                __DIR__.'/../config/filament-versions.php' => config_path('filament-versions.php'),
            ], 'filament-versions-config');
        }
    }
}
