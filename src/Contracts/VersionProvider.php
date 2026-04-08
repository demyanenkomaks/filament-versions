<?php

namespace Maksde\FilamentVersions\Contracts;

use BackedEnum;

interface VersionProvider
{
    public function getLabel(): string;

    public function getVersion(): string;

    public function getIcon(): string|BackedEnum|null;

    /**
     * @return array<string, int|string|null>|int|string|null
     */
    public function getColumnSpan(): array|int|string|null;

    /**
     * Secondary line under the value in {@see Stat} (optional).
     */
    public function getDescription(): ?string;
}
