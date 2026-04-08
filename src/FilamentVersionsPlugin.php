<?php

namespace Maksde\FilamentVersions;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Maksde\FilamentVersions\Contracts\VersionProvider;
use Maksde\FilamentVersions\Pages\VersionsPage;

final class FilamentVersionsPlugin implements Plugin
{
    /**
     * @var list<class-string<VersionProvider>>
     */
    protected array $extraWidgetProviders = [];

    /**
     * @var list<class-string<VersionProvider>>
     */
    protected array $extraPageProviders = [];

    public static function make(): self
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'maksde-filament-versions';
    }

    /**
     * @param  list<class-string<VersionProvider>>  $classes
     */
    public function widgetProviders(array $classes): self
    {
        $this->extraWidgetProviders = [...$this->extraWidgetProviders, ...$classes];

        return $this;
    }

    /**
     * @param  list<class-string<VersionProvider>>  $classes
     */
    public function pageProviders(array $classes): self
    {
        $this->extraPageProviders = [...$this->extraPageProviders, ...$classes];

        return $this;
    }

    /**
     * @return list<class-string<VersionProvider>>
     */
    public function getWidgetProviderClasses(): array
    {
        return [
            ...config('filament-versions.widget.providers', []),
            ...$this->extraWidgetProviders,
        ];
    }

    /**
     * @return list<class-string<VersionProvider>>
     */
    public function getPageProviderClasses(): array
    {
        return [
            ...config('filament-versions.page.providers', []),
            ...$this->extraPageProviders,
        ];
    }

    public function register(Panel $panel): void
    {
        if (config('filament-versions.page.enabled')) {
            $panel->pages([
                VersionsPage::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
