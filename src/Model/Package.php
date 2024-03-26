<?php

declare(strict_types=1);

namespace ComposerJsonParser\Model;

use ComposerJsonParser\Enum\PackageTypeEnum;

final readonly class Package
{
    public function __construct(
        private string $name,
        private string $version,
        private PackageTypeEnum $type,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getType(): PackageTypeEnum
    {
        return $this->type;
    }

}