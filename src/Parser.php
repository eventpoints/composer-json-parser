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

final readonly class Parser
{

    /**
     * @throws Exception
     */
    public function __invoke(): Composer
    {
        $composerFinder = new ComposerJsonFinder();
        $composerJsonData = $composerFinder->getComposerJsonData();

        if(!is_array($composerJsonData)){
            throw new Exception('can not find composer.json');
        }

        $composer = new Composer();
        $versionParser = new VersionParser();


        if (array_key_exists(key: 'name', array: $composerJsonData)) {
            $composer->setName($composerJsonData['name']);
        }

        if (array_key_exists(key: 'description', array: $composerJsonData)) {
            $composer->setDescription($composerJsonData['description']);
        }

        if (array_key_exists(key: 'type', array: $composerJsonData)) {
            $composer->setType($composerJsonData['type']);
        }

        if (array_key_exists(key: 'version', array: $composerJsonData)) {
            $composer->setVersion($versionParser->parseVersionString($composerJsonData['version']));
        }

        if (array_key_exists(key: 'minimum-stability', array: $composerJsonData)) {
            $composer->setMinimumStability($composerJsonData['minimum-stability']);
        }

        if (array_key_exists(key: 'require', array: $composerJsonData)) {
            $this->extractRequirePackages(composerRequirePackages: $composerJsonData['require'], composerRequireDevPackages: $composerJsonData['require-dev'], composer: $composer);
        }

        if (array_key_exists(key: 'autoload', array: $composerJsonData)) {
            $this->extractAutoloads(composerAutoload: $composerJsonData['autoload']['psr-4'], composerDevAutoload: $composerJsonData['autoload-dev']['psr-4'], composer: $composer);
        }

        if (array_key_exists(key: 'scripts', array: $composerJsonData)) {
            $this->extractScripts(composerScripts: $composerJsonData['scripts'], composer: $composer);
        }

        return $composer;
    }

    private function extractRequirePackages(array $composerRequirePackages, array $composerRequireDevPackages, Composer $composer): void
    {
        $versionParser = new VersionParser();

        foreach ($composerRequirePackages as $name => $version) {
            $package = new Package(name: $name, packageVersion: $versionParser->parseVersionString($version), type: PackageTypeEnum::DEVELOPMENT);
            $composer->addRequire($package);
        }

        foreach ($composerRequireDevPackages as $name => $version) {
            $package = new Package(name: $name, packageVersion: $versionParser->parseVersionString($version), type: PackageTypeEnum::REQUIRE);
            $composer->addDevRequire($package);
        }
    }

    private function extractAutoloads(array $composerAutoload, array $composerDevAutoload, Composer $composer): void
    {
        foreach ($composerAutoload as $namespace => $path) {
            $autoload = new Autoload(namespace: $namespace, path: $path);
            $composer->addAutoload($autoload);
        }


        foreach ($composerDevAutoload as $namespace => $path) {
            $autoload = new Autoload(namespace: $namespace, path: $path);
            $composer->addDevAutoload($autoload);
        }
    }

    private function extractScripts(array $composerScripts, Composer $composer): void
    {
        foreach ($composerScripts as $name => $command) {

            if (is_array($command)) {
                continue;
            }

            $script = new Script(name: $name, command: $command);

            $composer->addScript($script);
        }
    }

}