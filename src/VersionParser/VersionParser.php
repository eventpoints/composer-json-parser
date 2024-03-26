<?php

namespace ComposerJsonParser\VersionParser;

use ComposerJsonParser\Model\PackageVersion;

final class VersionParser
{
    public function parseVersionString(string $versionString): null|PackageVersion
    {
        if (str_ends_with($versionString, '*')) {
            return $this->parseWildcardVersion($versionString);
        } else {
            return $this->parseRegularVersion($versionString);
        }
    }

    private function parseWildcardVersion(string $versionString): null|PackageVersion
    {
        $wildcardPattern = '/^(?<version>.*?)(?<constraint>\*\s*)$/';
        if (preg_match($wildcardPattern, $versionString, $matches)) {
            $version = round((float)$matches['version'], 2);
            return new PackageVersion(version: $version, versionConstraints: '*');
        }
        return null;
    }

    private function parseRegularVersion(string $versionString): null|PackageVersion
    {
        $pattern = '/^(?:(?<constraint>[<>]=?|\^|~))?'
            . '(?<version>\d+(\.\d+)?(.\d+)?)$/';
        if (preg_match($pattern, $versionString, $matches)) {
            $versionConstraints = $matches['constraint'] ?? '';
            $version = $matches['version'];
            return new PackageVersion(version: (float)$version, versionConstraints: $versionConstraints);
        }
        return null;
    }
}
