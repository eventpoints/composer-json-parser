<?php

declare(strict_types=1);

namespace ComposerJsonParser;

use ComposerJsonParser\ComposerJsonFinder\ComposerJsonFinder;
use ComposerJsonParser\Enum\PackageTypeEnum;
use ComposerJsonParser\Model\Autoload;
use ComposerJsonParser\Model\Composer;
use ComposerJsonParser\Model\Package;
use ComposerJsonParser\Model\Script;
use ComposerJsonParser\VersionParser\VersionParser;
use Exception;

final class Parser
{
    private Composer $composer;
    private array $composerJsonData;
    private VersionParser $versionParser;


    public function __construct()
    {
        $this->composerJsonData = (new ComposerJsonFinder())->getComposerJsonData();
        $this->versionParser = new VersionParser();
        $this->composer = new Composer();
    }

    public function getComposer(): Composer
    {
        return $this->composer;
    }

    public function withName(): self
    {
        if (array_key_exists('name', $this->composerJsonData)) {
            $this->composer->setName($this->composerJsonData['name']);
        }
        return $this;
    }

    public function withDescription(): self
    {
        if (array_key_exists('description', $this->composerJsonData)) {
            $this->composer->setDescription($this->composerJsonData['description']);
        }
        return $this;
    }

    public function withType(): self
    {
        if (array_key_exists('type', $this->composerJsonData)) {
            $this->composer->setType($this->composerJsonData['type']);
        }

        return $this;
    }

    public function withVersion(): self
    {
        if (array_key_exists('version', $this->composerJsonData)) {
            $this->composer->setVersion($this->versionParser->parseVersionString($this->composerJsonData['version']));
        }
        return $this;
    }

    public function withMinimumStability(): self
    {
        if (array_key_exists('minimum-stability', $this->composerJsonData)) {
            $this->composer->setMinimumStability($this->composerJsonData['minimum-stability']);
        }
        return $this;
    }

    public function withRequire(): self
    {
        if (array_key_exists('require', $this->composerJsonData)) {
            $this->extractRequirePackages($this->composerJsonData['require']);
        }
        return $this;
    }

    public function withAutoloads(): self
    {
        if (array_key_exists('autoload', $this->composerJsonData) &&
            array_key_exists('psr-4', $this->composerJsonData['autoload'])) {

            $this->extractAutoloads($this->composerJsonData['autoload']['psr-4']);
        }
        return $this;
    }

    public function withScripts(): self
    {
        if (array_key_exists('scripts', $this->composerJsonData)) {
            $this->extractScripts($this->composerJsonData['scripts']);
        }
        return $this;
    }

    private function extractRequirePackages(array $composerRequirePackages): void
    {
        foreach ($composerRequirePackages as $name => $version) {
            $package = new Package(
                name: $name,
                type: PackageTypeEnum::DEVELOPMENT,
                packageVersion: $this->versionParser->parseVersionString($version)
            );
            $this->composer->addRequire($package);
        }
    }

    private function extractAutoloads(array $composerAutoload): void
    {
        foreach ($composerAutoload as $namespace => $path) {
            $autoload = new Autoload(namespace: $namespace, path: $path);
            $this->composer->addAutoload($autoload);
        }
    }

    private function extractScripts(array $composerScripts): void
    {
        foreach ($composerScripts as $name => $command) {
            if (is_array($command)) {
                continue;
            }

            $script = new Script(name: $name, command: $command);
            $this->composer->addScript($script);
        }
    }
}
