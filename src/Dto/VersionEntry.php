<?php

namespace Maksde\FilamentVersions\Dto;

use BackedEnum;
use Maksde\FilamentVersions\Contracts\VersionProvider;

/**
 * @phpstan-type ColumnSpan array<string, int|string|null>|int|string|null
 */
final readonly class VersionEntry
{
    /**
     * @param  ColumnSpan  $columnSpan
     */
    public function __construct(
        public string $label,
        public string $version,
        public string|BackedEnum|null $icon,
        public array|int|string|null $columnSpan,
        public ?string $description,
    ) {}

    public static function fromProvider(VersionProvider $provider): self
    {
        return new self(
            $provider->getLabel(),
            $provider->getVersion(),
            $provider->getIcon(),
            $provider->getColumnSpan(),
            $provider->getDescription(),
        );
    }
}
