<?php

namespace Entity\Abstraction\Accessor;

/**
 * @author     Merten van Gerven
 * @category   Entity
 * @package    Entity\Accessor
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

