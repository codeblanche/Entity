<?php

namespace EntityMarshal;

class ObjectPropertyHelper
{

    /**
     * Retrieve the object vars of $object from a public scope.
     *
     * @param   object  $object
     *
     * @return  array
     */
    public static function getObjectVars($object)
    {
        return get_object_vars($object);
    }

}
