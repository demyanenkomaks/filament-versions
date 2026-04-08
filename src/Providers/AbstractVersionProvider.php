<?php

namespace Maksde\FilamentVersions\Providers;

use BackedEnum;
use Maksde\FilamentVersions\Contracts\VersionProvider;

abstract class AbstractVersionProvider implements VersionProvider
{
    public function getIcon(): string|BackedEnum|null
    {
        return null;
    }

    public function getColumnSpan(): array|int|string|null
    {
        return 1;
    }

    public function getDescription(): ?string
    {
        return null;
    }
}
