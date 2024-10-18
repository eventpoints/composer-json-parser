# Composer Json Parser

## Convert your composer.json file to an object and find any data quickly.

### Install

`composer require eventpoints/composer-json-parser`

### Usage

Basic usage
````php
        $composer = (new Parser())
            ->withName()
             ->withRequire()
              ->withRequireDev()
               ->withAutoload()
                ->withMinimumStability()
                 ->withScripts()
                  ->getComposer();
        // Will output a Composer object
````

Need to find a specific package? 
````php
declare(strict_types=1);

namespace App;

use ComposerJsonParser\Parser;

class ExampleClass
{

     public function someMethod() : void 
     {
        $composer = (new Parser())->withRequire()->getComposer();
        $doctrineOrmPackage = $composer->getRequire()->findFirst(fn (int $key, Package $package) =>  $package->getName() == 'php');
        var_dump($doctrineOrmPackage);
           
//        object(ComposerJsonParser\Model\Package)#22 (3) {
//          ["name":"ComposerJsonParser\Model\Package":private]=>
//          string(12) "doctrine/orm"
//          ["type":"ComposerJsonParser\Model\Package":private]=>
//          enum(ComposerJsonParser\Enum\PackageTypeEnum::DEVELOPMENT)
//          ["packageVersion":"ComposerJsonParser\Model\Package":private]=>
//          object(ComposerJsonParser\Model\PackageVersion)#23 (2) {
//            ["version"]=>
//            float(3.1)
//            ["versionConstraints"]=>
//            string(1) "^"
//          }
//        }

        
     }
    
}
````