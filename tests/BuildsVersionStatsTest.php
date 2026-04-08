<?php

namespace Maksde\FilamentVersions\Tests;

use Filament\Widgets\StatsOverviewWidget\Stat;
use InvalidArgumentException;
use Maksde\FilamentVersions\Providers\FilamentVersionProvider;
use Maksde\FilamentVersions\Providers\PhpVersionProvider;
use Maksde\FilamentVersions\Support\BuildsVersionStats;

class BuildsVersionStatsTest extends TestCase
{
    public function test_builds_stats_from_providers(): void
    {
        $builder = $this->app->make(BuildsVersionStats::class);

        $stats = $builder->build([
            PhpVersionProvider::class,
            FilamentVersionProvider::class,
        ]);

        $this->assertCount(2, $stats);
        $this->assertContainsOnlyInstancesOf(Stat::class, $stats);
    }

    public function test_rejects_non_provider_class(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->app->make(BuildsVersionStats::class)->build([
            self::class,
        ]);
    }
}
