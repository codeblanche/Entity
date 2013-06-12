<?php

namespace Entity\Converter\Abstraction;

use Entity\Converter\Abstraction\ConverterStrategyInterface;

/**
 * @author      Merten van Gerven
 * @category    Entity
 * @package     Entity\ConverterStrategy
 * @abstract
 */
abstract class ConverterStrategy implements ConverterStrategyInterface
{
    /**
     * @var     array   List of object references to check for circular referencing.
     */
    protected $objectReferences = array();

    /**
     * @param  object|array $value
     *
     * @return boolean
     */
    protected function isCircularReference(&$value)
    {
        if (gettype($value) !== 'object') {
            return false;
        }

        $referenceFound = false;

        foreach ($this->objectReferences as $reference) {
            if ($reference === $value) {
                $referenceFound = true;
                break;
            }
        }

        $this->objectReferences[] = $value;

        return $referenceFound;
    }
}

