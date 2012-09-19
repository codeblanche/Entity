<?php

namespace EntityMarshal\Accessor;

/**
 * @author     Merten van Gerven
 * @category   EntityMarshal
 * @package    EntityMarshal\Accessor
 */
interface ObjectPropertyInterface extends AccessorInterface
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

