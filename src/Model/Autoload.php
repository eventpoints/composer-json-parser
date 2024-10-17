<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Model;

final readonly class Autoload
{
    public function __construct(
        private string $namespace,
        private string $path,
    ) {
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
