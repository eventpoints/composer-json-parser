# Composer Json Parser

## Convert your composer.json file to an object and find any data quickly.


### Install

`composer require eventpoints/composer-json-parser`

### Usage

````php
declare(strict_types=1);

namespace App;

use ComposerJsonParser\ParserFacade;

class ExampleClass
{

     public function someMethod() : void 
     {
        $composer = (new ParserFacade())->extract();
        $package = $composer->getPackageByName('rector/rector');
        
        var_dump($package->getPackageVersion());
        
//        object(ComposerJsonParser\Model\PackageVersion)#29 (2) {
//            ["version"] => float(0.18)
//            ["versionConstraints"] => string(1) "^" 
//       }
        
     }
    
}
````