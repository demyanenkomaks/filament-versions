<?php

namespace Maksde\FilamentVersions\Widgets\Concerns;

use Maksde\FilamentVersions\Contracts\VersionProvider;
use Maksde\FilamentVersions\Support\BuildsVersionStats;

trait ResolvesVersionStats
{
    /**
     * @return list<class-string<VersionProvider>>
     */
    abstract protected function versionProviderClasses(): array;

    protected function getStats(): array
    {
        $classes = $this->versionProviderClasses();

        if ($classes === []) {
            return [];
        }

        return app(BuildsVersionStats::class)->build($classes);
    }
}
