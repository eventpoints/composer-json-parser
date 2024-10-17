<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Model;

readonly class PackageVersion
{
    public function __construct(
        public float $version,
        public string $versionConstraints
    )
    {
    }

    public function getVersion(): float
    {
        return $this->version;
    }

    public function getVersionConstraints(): string
    {
        return $this->versionConstraints;
    }
}
