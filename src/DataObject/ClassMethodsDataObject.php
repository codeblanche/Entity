<?php

namespace DataObject;

/**
 * Description of ClassMethodsDataObject
 *
 * @author merten
 */
abstract class ClassMethodsDataObject extends DataObject implements ClassMethodsAccessorInterface
{

    public function __call($name, $arguments)
    {
        //;
    }

}
