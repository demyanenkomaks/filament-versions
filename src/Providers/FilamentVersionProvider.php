<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Composer\InstalledVersions;
use Filament\Support\Icons\Heroicon;
use Throwable;

class FilamentVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.filament');
    }

    public function getVersion(): string
    {
        try {
            return InstalledVersions::getVersion('filament/filament') ?? 'n/a';
        } catch (Throwable $throwable) {
            return $throwable->getMessage();
        }
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedSquares2x2;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.filament_description');
    }
}
