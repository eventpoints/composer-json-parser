<?php

declare(strict_types=1);

namespace ComposerJsonParser\Model;

use ComposerJsonParser\Enum\PackageTypeEnum;

final readonly class Package
{
    public function __construct(
        private string $name,
        private PackageTypeEnum $type,
        private null|PackageVersion $version = null
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): null|PackageVersion
    {
        return $this->version;
    }

    public function getType(): PackageTypeEnum
    {
        return $this->type;
    }

}