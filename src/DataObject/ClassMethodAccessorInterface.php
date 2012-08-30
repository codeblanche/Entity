<?php

namespace DataObject;

/**
 * @author     Merten van Gerven
 * @package    DataObject
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
