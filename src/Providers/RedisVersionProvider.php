<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Redis;
use Throwable;

class RedisVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('filament-versions::filament-versions.defaults.redis');
    }

    public function getVersion(): string
    {
        try {
            $info = Redis::connection()->info();

            $version = $this->extractRedisVersion(is_array($info) ? $info : []);

            return $version ?? 'n/a';
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedServerStack;
    }

    public function getDescription(): ?string
    {
        return __('filament-versions::filament-versions.defaults.redis_description');
    }

    /**
     * @param  array<string, mixed>  $info
     */
    protected function extractRedisVersion(array $info): ?string
    {
        if (isset($info['redis_version']) && is_string($info['redis_version'])) {
            return $info['redis_version'];
        }

        foreach ($info as $value) {
            if (! is_array($value)) {
                continue;
            }
            $nested = $this->extractRedisVersion($value);
            if ($nested !== null) {
                return $nested;
            }
        }

        return null;
    }
}
