<?php

namespace EntityMarshal\EntityAccessor;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal\EntityAccessor
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
