<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Foundation\Application;

class LaravelVersionProvider extends AbstractVersionProvider
{
    public function __construct(protected Application $app) {}

    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.laravel');
    }

    public function getVersion(): string
    {
        return $this->app->version();
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedBolt;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.laravel_description');
    }
}
