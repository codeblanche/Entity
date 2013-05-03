<?php

namespace EntityMarshal\Abstraction\Accessor;

/**
 * @author     Merten van Gerven
 * @category   EntityMarshal
 * @package    EntityMarshal\Accessor
 */
interface ClassMethodInterface extends AccessorInterface
{
    /**
     * Magic setter/getter handler
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments);
}

