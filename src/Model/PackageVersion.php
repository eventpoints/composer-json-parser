<?php

namespace ComposerJsonParser\Model;

readonly class PackageVersion
{
    public float $version;
    public string $versionConstraints;

    public function __construct(float $version, string $versionConstraints)
    {
        $this->version = $version;
        $this->versionConstraints = $versionConstraints;
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