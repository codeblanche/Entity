<?php

namespace EntityMarshal\RuntimeCache;

use Serializable;

final class RuntimeCacheSingleton implements RuntimeCacheInterface, Serializable
{
    const SCOPE_DEFAULT = 'global';

    /**
    * @var array
    */
    private $cache = array();

    /**
     * @var string
     */
    private $scope;

    /**
    * @var RuntimeCacheSingleton Singleton instance.
    */
    private static $instance;

    /**
    * {@inheritdoc}
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
     * Private constructor to ensure singularity
     */
    private function __construct()
    {
        $this->scope = self::SCOPE_DEFAULT;
    }

    /**
     * {@inheritdoc}
     */
    public function setScope($scope = null)
    {
        if (is_null($scope)) {
            return $this->clearScope();
        }

        $this->scope = $scope;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * {@inheritdoc}
     */
    public function clearScope()
    {
        $this->scope = self::SCOPE_DEFAULT;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $scope = null)
    {
        $scope = is_null($scope) ? $this->getScope() : $scope;

        return $this->has($key, $scope)
            ? $this->cache[$scope][$key]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key, $scope = null)
    {
        $scope = is_null($scope) ? $this->getScope() : $scope;

        return isset($this->cache[$scope][$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $scope = null)
    {
        $scope = is_null($scope) ? $this->getScope() : $scope;

        $this->cache[$scope][$key] = $value;

        return $this;
    }

    public function remove($key, $scope = null)
    {
        $scope = is_null($scope) ? $this->getScope() : $scope;

        unset($this->cache[$scope][$key]);

        return $this;
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
        $this->scope = self::SCOPE_DEFAULT;
        $this->cache = unserialize($serialized);
    }
}

