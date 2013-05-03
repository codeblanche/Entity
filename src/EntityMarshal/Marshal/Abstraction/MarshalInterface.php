<?php

namespace EntityMarshal\Marshal\Abstraction;

use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\Marshal
 */
interface MarshalInterface
{
    /**
     * Marshal a given value and return the result or throw an exception
     *
     * @param   mixed                       $value         Value to be allocated to property name
     * @param   PropertyDefinitionInterface $definition    Property definition object if there is one.
     *
     * @return  mixed                       Marshaled value
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null);
}
