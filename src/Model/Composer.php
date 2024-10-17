<?php

declare(strict_types=1);

namespace KerrialNewham\ComposerJsonParser\Model;

use Doctrine\Common\Collections\ArrayCollection;

final class Composer
{
    private null|string $name = null;

    private null|string $description = null;

    private null|string $type = null;

    private null|PackageVersion $version = null;

    private null|string $minimumStability = null;

    private readonly ArrayCollection $require;

    private readonly ArrayCollection $config;

    private readonly ArrayCollection $autoload;

    private readonly ArrayCollection $devAutoload;

    private readonly ArrayCollection $replace;

    private readonly ArrayCollection $scripts;

    private readonly ArrayCollection $conflict;

    private readonly ArrayCollection $extra;

    private readonly ArrayCollection $requireDev;

    public function __construct()
    {
        $this->require = new ArrayCollection();
        $this->config = new ArrayCollection();
        $this->autoload = new ArrayCollection();
        $this->devAutoload = new ArrayCollection();
        $this->replace = new ArrayCollection();
        $this->scripts = new ArrayCollection();
        $this->conflict = new ArrayCollection();
        $this->extra = new ArrayCollection();
        $this->requireDev = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getVersion(): ?PackageVersion
    {
        return $this->version;
    }

    public function setVersion(?PackageVersion $version): void
    {
        $this->version = $version;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getMinimumStability(): string
    {
        return $this->minimumStability;
    }

    public function setMinimumStability(string $minimumStability): void
    {
        $this->minimumStability = $minimumStability;
    }

    /**
     * @return ArrayCollection<int, Package>
     */
    public function getRequire(): ArrayCollection
    {
        return $this->require;
    }

    public function addRequire(Package $package)
    {
        $this->require->add($package);
    }

    /**
     * @return ArrayCollection<int, Package>
     */
    public function getRequireDev(): ArrayCollection
    {
        return $this->requireDev;
    }

    public function addDevRequire(Package $package)
    {
        $this->requireDev->add($package);
    }

    public function getConfig(): ArrayCollection
    {
        return $this->config;
    }

    public function addConfig(string $key, string $value)
    {
        $this->config->set($key, $value);
    }

    /**
     * @return ArrayCollection<int, Autoload>
     */
    public function getAutoload(): ArrayCollection
    {
        return $this->autoload;
    }

    public function addAutoload(Autoload $autoload): void
    {
        $this->autoload->add($autoload);
    }

    /**
     * @return ArrayCollection<int, Autoload>
     */
    public function getDevAutoload(): ArrayCollection
    {
        return $this->devAutoload;
    }

    public function addDevAutoload(Autoload $autoload): void
    {
        $this->devAutoload->add($autoload);
    }

    /**
     * @return ArrayCollection<int, Script>
     */
    public function getScripts(): ArrayCollection
    {
        return $this->scripts;
    }

    public function addScript(Script $script): void
    {
        $this->scripts->add($script);
    }

    public function getRequirePackageByName(string $name): null|Package
    {
        return $this->getRequire()->findFirst(fn (int $key, Package $package): bool => $name === $package->getName());
    }

    public function getDevPackageByName(string $name): null|Package
    {
        return $this->getRequireDev()->findFirst(fn (int $key, Package $package): bool => $name === $package->getName());
    }

    public function getPackageByName(string $name): null|Package
    {
        $packages = new ArrayCollection([
            ...$this->getRequire(),
            ...$this->getRequireDev(),
        ]);

        return $packages->findFirst(fn (int $key, Package $package): bool => $name === $package->getName());
    }
}
