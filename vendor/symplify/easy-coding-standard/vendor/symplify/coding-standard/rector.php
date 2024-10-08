<?php

declare (strict_types=1);
namespace ECSPrefix202402;

use ECSPrefix202402\Rector\Config\RectorConfig;
return RectorConfig::configure()->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])->withPhpSets()->withPreparedSets(\false, \true, \true, \false, \true, \true, \false, \true)->withImportNames(\true, \true, \true, \true)->withSkip(['*/Source/*', '*/Fixture/*']);
