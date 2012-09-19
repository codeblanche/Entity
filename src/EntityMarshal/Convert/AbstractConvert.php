<?php

namespace EntityMarshal\Convert;

use EntityMarshal\Convert\Strategy\StrategyInterface;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\ConverterStrategy
 * @abstract
 */
abstract class AbstractConvert implements StrategyInterface
{
    /**
     * @var     array   List of object references to check for circular referencing.
     */
    protected $objectReferences;

    /**
     * @param  object|array $value
     * @return boolean
     */
    protected function isCircularReference(&$value)
    {
        $type = gettype($value);

        if ($type !== 'object') {
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

