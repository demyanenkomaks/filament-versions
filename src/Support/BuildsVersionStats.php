<?php

namespace Maksde\FilamentVersions\Support;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Maksde\FilamentVersions\Contracts\VersionProvider;
use Maksde\FilamentVersions\Dto\VersionEntry;

final class BuildsVersionStats
{
    public function __construct(protected Application $app) {}

    /**
     * @param  list<string>  $providerClasses  Class names implementing {@see VersionProvider}
     * @return list<Stat>
     */
    public function build(array $providerClasses): array
    {
        $stats = [];

        foreach ($providerClasses as $class) {
            if (! class_exists($class) || ! is_subclass_of($class, VersionProvider::class)) {
                throw new InvalidArgumentException(sprintf(
                    'Expected class implementing %s, got [%s].',
                    VersionProvider::class,
                    $class,
                ));
            }

            $provider = $this->app->make($class);
            $entry = VersionEntry::fromProvider($provider);

            $stat = Stat::make($entry->label, $entry->version);

            if ($entry->icon !== null) {
                $stat->icon($entry->icon);
            }

            if ($entry->columnSpan !== null) {
                $stat->columnSpan($entry->columnSpan);
            }

            if ($entry->description !== null && $entry->description !== '') {
                $stat->description($entry->description);
            }

            $stats[] = $stat;
        }

        return $stats;
    }
}
