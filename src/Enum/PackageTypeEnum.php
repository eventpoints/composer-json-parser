<?php

namespace ComposerJsonParser\Enum;

enum PackageTypeEnum: string
{
    case DEVELOPMENT = 'development';
    case REQUIRE = 'require';

}
