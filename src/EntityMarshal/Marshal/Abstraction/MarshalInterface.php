<?php

namespace EntityMarshal\Marshal\Abstraction;

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
     * @param   string $name       Property name
     * @param   string $type       Expected/desired type for the value
     * @param   mixed  $value      Value to be allocated to property name
     * @param   bolean $defined    Indicates whether property is defined (true) or dynamic (false)
     *
     * @return  mixed               Marshaled value
     */
    public function ratify($name, $type, $value, $defined);
}
