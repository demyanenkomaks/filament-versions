<?php

namespace Maksde\FilamentVersions\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Contracts\Support\Htmlable;
use Maksde\FilamentVersions\Widgets\VersionsPageWidget;

class VersionsPage extends Page
{
    public static function getDefaultSlug(): string
    {
        return config('filament-versions.page.path', 'versions');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-versions.page.should_register_navigation', true);
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-versions::filament-versions.page.navigation_label');
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        $group = __('filament-versions::filament-versions.page.navigation_group');

        return $group === '' ? null : $group;
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return config('filament-versions.page.navigation_icon');
    }

    public static function getNavigationSort(): ?int
    {
        $sort = config('filament-versions.page.navigation_sort');

        return $sort !== null ? (int) $sort : null;
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-versions::filament-versions.page.title');
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            VersionsPageWidget::class,
        ];
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
