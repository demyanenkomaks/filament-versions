<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Throwable;

class MysqlVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.mysql');
    }

    public function getVersion(): string
    {
        try {
            $row = DB::connection()->selectOne('SELECT VERSION() AS value');

            return (string) ($row->value ?? 'n/a');
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedCircleStack;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.mysql_description');
    }
}
