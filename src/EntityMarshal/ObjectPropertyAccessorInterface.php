<?php

namespace EntityMarshal;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
interface ObjectPropertyAccessorInterface extends AccessorInterface
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
