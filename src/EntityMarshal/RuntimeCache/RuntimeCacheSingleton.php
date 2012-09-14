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
    private static $instance;

    /**
    * SimpleAutoloader singleton factory method.
    *
    * @return SimpleAutloader
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
        $this->position = 0;
    }

    // Implement Iterator

    /**
     * @var integer
     */
    private $position = 0;

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $keys   = array_keys($this->cache);
        $key    = $keys[$this->position];

        return $this->cache[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $keys   = array_keys($this->cache);

        return $keys[$this->position];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->cache[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->cache[$offset])
            ? $this->cache[$offset]
            : null ;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->cache[$offset]);
    }

    // Implement Serializable

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->cache);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->cache = unserialize($serialized);
    }

    // Implement Countable

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->cache);
    }

}


