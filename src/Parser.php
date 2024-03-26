<?php

namespace ComposerJsonParser;

use ComposerJsonParser\Enum\PackageTypeEnum;
use ComposerJsonParser\Model\Autoload;
use ComposerJsonParser\Model\Composer;
use ComposerJsonParser\Model\Package;
use ComposerJsonParser\Model\Script;

final readonly class Parser
{

    public function __invoke(): Composer
    {
        $composerJsonData = json_decode(file_get_contents(realpath(__DIR__ . '/../../../../../composer.json')), true);

        $composer = new Composer(
            name: $composerJsonData['name'],
            description: $composerJsonData['description'],
            type: $composerJsonData['type'],
            minimumStability: $composerJsonData['minimum-stability'],
        );

        $this->extractRequirePackages(composerRequirePackages: $composerJsonData['require'], composerRequireDevPackages: $composerJsonData['require-dev'], composer: $composer);
        $this->extractAutoloads(composerAutoload: $composerJsonData['autoload']['psr-4'], composerDevAutoload: $composerJsonData['autoload-dev']['psr-4'], composer: $composer);
        $this->extractScripts(composerScripts: $composerJsonData['scripts'], composer: $composer);
        return $composer;
    }

    private function extractRequirePackages(array $composerRequirePackages, array $composerRequireDevPackages, Composer $composer): void
    {
        foreach ($composerRequirePackages as $name => $version) {
            $package = new Package(name: $name, version: $version, type: PackageTypeEnum::DEVELOPMENT);
            $composer->addRequire($package);
        }

        foreach ($composerRequireDevPackages as $name => $version) {
            $package = new Package(name: $name, version: $version, type: PackageTypeEnum::REQUIRE);
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