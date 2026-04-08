<?php

namespace Maksde\FilamentVersions\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Maksde\FilamentVersions\FilamentVersionsPlugin;
use Maksde\FilamentVersions\Support\FilamentVersionsAccess;
use Maksde\FilamentVersions\Widgets\Concerns\ResolvesVersionStats;

class VersionsPageWidget extends StatsOverviewWidget
{
    use ResolvesVersionStats;

    protected static bool $isDiscovered = false;

    protected static ?int $sort = null;

    public function mount(): void
    {
        $this->columnSpan = 'full';
    }

    public static function canView(): bool
    {
        return FilamentVersionsAccess::canViewVersionsPageWidget();
    }

    protected function versionProviderClasses(): array
    {
        return FilamentVersionsPlugin::make()->getPageProviderClasses();
    }
}
