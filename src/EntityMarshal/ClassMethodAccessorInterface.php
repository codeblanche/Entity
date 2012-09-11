<?php

namespace EntityMarshal;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
interface ClassMethodAccessorInterface extends AccessorInterface
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
