<?php

namespace Maksde\FilamentVersions\Tests;

use Maksde\FilamentVersions\FilamentVersionsServiceProvider;
use Maksde\FilamentVersions\Providers\PhpVersionProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentVersionsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('filament-versions.widget.providers', [
            PhpVersionProvider::class,
        ]);
        $app['config']->set('filament-versions.page.providers', [
            PhpVersionProvider::class,
        ]);
    }
}
