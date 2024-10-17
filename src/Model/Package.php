<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Model;

use KerrialNewham\ComposerJsonParser\Enum\PackageTypeEnum;

final readonly class Package
{
    public function __construct(
        private string $name,
        private PackageTypeEnum $type,
        private null|PackageVersion $packageVersion = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPackageVersion(): null|PackageVersion
    {
        return $this->packageVersion;
    }

    public function getType(): PackageTypeEnum
    {
        return $this->type;
    }
}
