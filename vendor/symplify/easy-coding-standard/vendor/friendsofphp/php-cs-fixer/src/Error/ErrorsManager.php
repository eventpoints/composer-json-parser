<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Error;

/**
 * Manager of errors that occur during fixing.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class ErrorsManager
{
    /**
     * @var list<Error>
     */
    private $errors = [];
    /**
     * Returns errors reported during linting before fixing.
     *
     * @return list<Error>
     */
    public function getInvalidErrors() : array
    {
        return \array_filter($this->errors, static function (\PhpCsFixer\Error\Error $error) : bool {
            return \PhpCsFixer\Error\Error::TYPE_INVALID === $error->getType();
        });
    }
    /**
     * Returns errors reported during fixing.
     *
     * @return list<Error>
     */
    public function getExceptionErrors() : array
    {
        return \array_filter($this->errors, static function (\PhpCsFixer\Error\Error $error) : bool {
            return \PhpCsFixer\Error\Error::TYPE_EXCEPTION === $error->getType();
        });
    }
    /**
     * Returns errors reported during linting after fixing.
     *
     * @return list<Error>
     */
    public function getLintErrors() : array
    {
        return \array_filter($this->errors, static function (\PhpCsFixer\Error\Error $error) : bool {
            return \PhpCsFixer\Error\Error::TYPE_LINT === $error->getType();
        });
    }
    /**
     * Returns errors reported for specified path.
     *
     * @return list<Error>
     */
    public function forPath(string $path) : array
    {
        return \array_values(\array_filter($this->errors, static function (\PhpCsFixer\Error\Error $error) use($path) : bool {
            return $path === $error->getFilePath();
        }));
    }
    /**
     * Returns true if no errors were reported.
     */
    public function isEmpty() : bool
    {
        return [] === $this->errors;
    }
    public function report(\PhpCsFixer\Error\Error $error) : void
    {
        $this->errors[] = $error;
    }
}
