<?php

namespace EntityMarshal\ConverterStrategy;

use EntityMarshal\AbstractEntityMarshal;
use EntityMarshal\EntityMarshalInterface;

/**
 * Convert and entity to a Json string
 *
 * @category EntityMarshal
 * @package  EntityMarshal\ConverterStrategy
 *
 * @todo     Populate stub
 */
abstract class AbstractConverterStrategy implements ConverterStrategyInterface
{

    /**
     * @var     array   List of object references to check for circular referencing.
     */
    protected $objectReferences;

    /**
     * @param    object|array    $value
     * @return   boolean
     */
    protected function isCircularReference(&$value)
    {
        $type = gettype($value);

        if ($type !== 'object') {
            return false;
        }

        $referenceFound = false;

        foreach ($this->objectReferences as $reference) {
            if($reference === $value) {
                $referenceFound = true;
                break;
            }
        }

        $this->objectReferences[] = $value;

        return $referenceFound;
    }

}