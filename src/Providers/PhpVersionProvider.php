<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class PhpVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.php');
    }

    public function getVersion(): string
    {
        return phpversion();
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedCodeBracket;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.php_description');
    }
}
