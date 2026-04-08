<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostgresqlVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.postgresql');
    }

    public function getVersion(): string
    {
        try {
            $row = DB::connection()->selectOne('SELECT version() AS value');

            return (string) ($row->value ?? 'n/a');
        } catch (Throwable $throwable) {
            return $throwable->getMessage();
        }
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedCircleStack;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.postgresql_description');
    }
}
