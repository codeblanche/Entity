<?php

namespace EntityMarshal\RuntimeCache;

use Iterator;
use Traversable;
use ArrayAccess;
use Serializable;
use Countable;

final class RuntimeCacheSingleton implements Iterator, ArrayAccess , Serializable , Countable
{

    /**
    * @var array
    */
    private $cache = array();

    /**
    * @var RuntimeCacheSingleton Singleton instance.
    */
    static private $instance;

    /**
    * SimpleAutoloader singleton factory method.
    *
    * @return SimpleAutloader
    */
    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            $self             = __CLASS__;
            self::$instance = new $self();
        }

        return self::$instance;
    }

    /**
     * Private constructor to ensure singletonnnnness
     */
    private function __construct()
    {
        $this->position = 0;
    }

    // Implement Iterator

    /**
     * @var integer
     */
    private $position = 0;

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->cache[$this->position];
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     */
    public function next()
    {

    }

    /**
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid()
    {

    }

    // Implement ArrayAccess

    /**
     * @param mixed $index
     * @return bool
     */
    public function offsetExists($index)
    {

    }

    /**
     * @param mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {

    }

    /**
     * @param mixed $index
     * @param mixed $newval
     */
    public function offsetSet($index, $newval)
    {

    }

    /**
     * @param mixed $index
     */
    public function offsetUnset($index)
    {

    }

    // Implement Serializable

    /**
     * @return string
     */
    public function serialize()
    {

    }

    /**
     * @param string $val
     */
    public function unserialize($val)
    {

    }

    // Implement Countable

    /**
     * Count elements of an object
     * @return int
     */
    public function count()
    {

    }

}


