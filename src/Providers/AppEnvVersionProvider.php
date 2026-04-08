<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class AppEnvVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.app_env');
    }

    public function getVersion(): string
    {
        return config('app.env', 'n/a');
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedGlobeAlt;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.app_env_description');
    }
}
