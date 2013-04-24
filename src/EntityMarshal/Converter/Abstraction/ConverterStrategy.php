<?php

namespace EntityMarshal\Converter\Abstraction;

use EntityMarshal\Converter\Abstraction\ConverterStrategyInterface;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\ConverterStrategy
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

