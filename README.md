# Composer Json Parser


## Extracts all your composer.json file data converts it to an object with some useful methods to query your dependency data quickly.

- No more parsing Json & save time.
- No more arrays and fiddle array keys. 
- No more inconsistency and error handling.

### Install
`composer require eventpoints/composer-json-parser`

### Usage
Basic usage:

````php
public function someMethod() : void 
{
    // This will extract the composer.json file data return a (Composer)[https://github.com/eventpoints/composer-json-parser/blob/main/src/Model/Composer.php] object 
    $composer = (new ParserFacade())->extract();
}
````
Any collection of Packages for example `$composer->getRequires()` will be return a [Doctrine's ArrayCollection](https://www.doctrine-project.org/projects/doctrine-collections/en/stable/index.html), so you can access all the default methods available, making querying your dependencies very easy.
Example of getting all require packages and filter by version greater than 8.0:

````php
public function someMethod() : void 
{
    $composer = (new ParserFacade())->extract();
    $package = $composer->getRequires()->findFirst(fn(int $key, Package $package) => $package->getPackageVersion()->getVersion() > 8.0 );
    var_dump($package);
    
    //  object(ComposerJsonParser\Model\Package)#21 (3) {
    //  ["name":"ComposerJsonParser\Model\Package":private]=>
    //  string(3) "php"
    //  ["type":"ComposerJsonParser\Model\Package":private]=>
    //  enum(ComposerJsonParser\Enum\PackageTypeEnum::DEVELOPMENT)
    //  ["packageVersion":"ComposerJsonParser\Model\Package":private]=>
    //  object(ComposerJsonParser\Model\PackageVersion)#22 (2) {
    //    ["version"]=>
    //    float(8.2)
    //    ["versionConstraints"]=>
    //    string(1) "^"
    //  }
    // }
}
````

Example usage of get a package by name:

````php
public function someMethod() : void 
{
    $composer = (new ParserFacade())->extract();
    $package = $composer->getPackageByName('rector/rector');
    var_dump($package);
                
    // object(ComposerJsonParser\Model\Package)#29 (3) {
    //  ["name":"ComposerJsonParser\Model\Package":private]=>
    //  string(13) "rector/rector"
    //  ["type":"ComposerJsonParser\Model\Package":private]=>
    //  enum(ComposerJsonParser\Enum\PackageTypeEnum::REQUIRE)
    //  ["packageVersion":"ComposerJsonParser\Model\Package":private]=>
    //  object(ComposerJsonParser\Model\PackageVersion)#30 (2) {
    //    ["version"]=>
    //    float(0.18)
    //    ["versionConstraints"]=>
    //    string(1) "^"
    //  }
    // }
}
````