<?php

namespace EntityMarshal\EntityAccessor;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal\EntityAccessor
 */
interface ObjectPropertyEntityAccessorInterface extends EntityAccessorInterface
{

    /**
     * Magic getter.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function &__get($name);

    /**
     * Magic setter.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value);

}
