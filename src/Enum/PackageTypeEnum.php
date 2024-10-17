<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Enum;

enum PackageTypeEnum: string
{
    case DEVELOPMENT = 'development';
    case REQUIRE = 'require';
}
