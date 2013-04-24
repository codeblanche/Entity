<?php

namespace EntityMarshal\EntityConversion;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\ConverterStrategy
 * @abstract
 */
abstract class AbstractEntityConversionStrategy implements EntityConversionStrategyInterface
{
    /**
     * @var     array   List of object references to check for circular referencing.
     */
    protected $objectReferences = array();

    /**
     * @param  object|array $value
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

