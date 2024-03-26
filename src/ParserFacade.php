<?php

namespace ComposerJsonParser;

use ComposerJsonParser\Model\Composer;

final readonly class ParserFacade
{

    public function extract() : Composer
    {
        return (new Parser())();
    }

}