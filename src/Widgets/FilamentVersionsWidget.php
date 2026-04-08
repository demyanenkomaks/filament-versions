<?php

namespace Maksde\FilamentVersions\Widgets;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Widgets\StatsOverviewWidget;
use Maksde\FilamentVersions\FilamentVersionsPlugin;
use Maksde\FilamentVersions\Support\FilamentVersionsAccess;
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

    public static function canView(): bool
    {
        return FilamentVersionsAccess::canViewDashboardWidget();
    }

    protected function versionProviderClasses(): array
    {
        return FilamentVersionsPlugin::make()->getWidgetProviderClasses();
    }

    /**
     * Подпись для Filament Shield (и сходных сканеров прав), без вывода заголовка над карточками на дашборде — см. {@see getSectionContentComponent()}.
     */
    protected function getHeading(): ?string
    {
        return __('filament-versions::filament-versions.shield.widget_label');
    }

    public function getSectionContentComponent(): Component
    {
        return Section::make()
            ->heading(null)
            ->description($this->getDescription())
            ->schema($this->getCachedStats())
            ->columns($this->getColumns())
            ->contained(false)
            ->gridContainer();
    }
}
