<?php

namespace ComposerJsonParser\Model;

use Doctrine\Common\Collections\ArrayCollection;

final class Composer
{
    private ArrayCollection $require;
    private ArrayCollection $config;
    private ArrayCollection $autoload;
    private ArrayCollection $devAutoloads;
    private ArrayCollection $replace;
    private ArrayCollection $scripts;
    private ArrayCollection $conflict;
    private ArrayCollection $extra;
    private ArrayCollection $requireDev;

    public function __construct(
        private null|string $name = null,
        private null|string $description = null,
        private null|string $type = null,
        private string      $minimumStability
    )
    {
        $this->require = new ArrayCollection();
        $this->config = new ArrayCollection();
        $this->autoload = new ArrayCollection();
        $this->devAutoloads = new ArrayCollection();
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
    public function getRequires(): ArrayCollection
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
    public function getDevRequires(): ArrayCollection
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
    public function getAutoloads(): ArrayCollection
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
    public function getDevAutoloads(): ArrayCollection
    {
        return $this->devAutoloads;
    }

    public function addDevAutoload(Autoload $autoload): void
    {
        $this->devAutoloads->add($autoload);
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
        return $this->getRequires()->findFirst(fn(int $key, Package $package) => $name === $package->getName());
    }

    public function getDevPackageByName(string $name): null|Package
    {
        return $this->getDevRequires()->findFirst(fn(int $key, Package $package) => $name === $package->getName());
    }

    public function getPackageByName(string $name): null|Package
    {
        $packages = new ArrayCollection([
            ...$this->getRequires(),
            ...$this->getDevRequires()
        ]);

        return $packages->findFirst(fn(Package $package) => $name === $package->getName());
    }

}