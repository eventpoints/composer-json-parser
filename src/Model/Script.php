<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Model;

final readonly class Script
{
    public function __construct(
        private string $name,
        private string $command,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}
