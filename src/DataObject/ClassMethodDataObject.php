<?php

namespace DataObject;

/**
 * @author     Merten van Gerven
 * @package    DataObject
 */
abstract class ClassMethodDataObject extends DataObject implements ClassMethodAccessorInterface
{

    public function __call($name, $arguments)
    {
        //;
    }

}
