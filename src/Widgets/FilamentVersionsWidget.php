<?php

namespace Maksde\FilamentVersions\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Maksde\FilamentVersions\FilamentVersionsPlugin;
use Maksde\FilamentVersions\Widgets\Concerns\ResolvesVersionStats;

class FilamentVersionsWidget extends StatsOverviewWidget
{
    use ResolvesVersionStats;

    protected static bool $isDiscovered = false;

    protected static ?int $sort = -1;

    public function mount(): void
    {
        $this->columnSpan = config('filament-versions.widget.column_span', 'full');
    }

    public static function getSort(): int
    {
        $configured = config('filament-versions.widget.sort');

        if ($configured !== null) {
            return (int) $configured;
        }

        return static::$sort ?? -1;
    }

    protected function versionProviderClasses(): array
    {
        return FilamentVersionsPlugin::make()->getWidgetProviderClasses();
    }
}
