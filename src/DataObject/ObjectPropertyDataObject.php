<?php

namespace DataObject;

/**
 * @author     Merten van Gerven
 * @package    DataObject
 */
abstract class ObjectPropertyDataObject extends DataObject implements ObjectPropertyAccessorInterface
{

    public function &__get($name)
    {
        return $this->_get($name);
    }

    public function __set($name, $value)
    {
        $this->_set($name, $value);
    }

}
