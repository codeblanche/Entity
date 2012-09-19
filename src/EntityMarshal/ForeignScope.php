<?php

namespace EntityMarshal;

class ForeignScope
{
    /**
    * @var ForeignScope Singleton instance.
    */
    private static $instance;

    /**
     * @return ForeignScope
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $self           = __CLASS__;
            self::$instance = new $self();
        }

        return self::$instance;
    }

    /**
     * Private constructor to ensure singletonnnnness
     */
    private function __construct()
    {
    }

    /**
     * Retrieve the object vars of $object from a public scope.
     *
     * @param object $object
     *
     * @return array
     */
    public function getObjectVars($object)
    {
        return get_object_vars($object);
    }
}

