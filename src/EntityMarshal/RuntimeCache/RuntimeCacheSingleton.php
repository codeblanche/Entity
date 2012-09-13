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
        $keys   = array_keys($this->cache);
        $key    = $keys[$this->position];

        return $this->cache[$key];
    }

    /**
     * @return mixed
     */
    public function key()
    {
        $keys   = array_keys($this->cache);

        return $keys[$this->position];
    }

    /**
     */
    public function next()
    {
        ++$this->position;
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
        $keys = array_keys($this->cache);
        $key  = null;

        if ($this->position < count($keys)) {
            $key = $keys[$this->position];
        }

        return !is_null($key) 
            ? isset($this->cache[$key]) 
            : false ;
    }

    // Implement ArrayAccess

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->cache[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->cache[$offset]) 
            ? $this->cache[$offset] 
            : null ;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->cache[] = $value;
        } else {
            $this->cache[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->cache[$offset]);
    }

    // Implement Serializable

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->cache);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->cache = unserialize($serialized);
    }

    // Implement Countable

    /**
     * Count elements of an object
     * @return int
     */
    public function count()
    {
        return count($this->cache);
    }

}


