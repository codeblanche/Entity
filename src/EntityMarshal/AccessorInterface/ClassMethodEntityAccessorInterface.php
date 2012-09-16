<?php

namespace EntityMarshal\AccessorInterface;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal\AccessorInterface
 */
interface ClassMethodEntityAccessorInterface extends EntityAccessorInterface
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
