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

  
     public function someMethod(){
        $composer = new ParserFacade();
        $composer->getPackageByName(name: 'rector/rector')
        
        var_dump($rectorPackage?->getVersion()); // string(7) "^0.18.1"
     }
    
}
````