<?php

namespace DataObject;

/**
 *
 */
interface ClassMethodsAccessorInterface extends AccessorInterface
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
