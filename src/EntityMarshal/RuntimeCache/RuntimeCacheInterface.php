<?php

namespace EntityMarshal\RuntimeCache;

interface RuntimeCacheInterface
{
    /**
     * @return RuntimeCacheInterface
     */
    public static function getInstance();

    /**
     * Switch runtime cache to non-global scope
     *
     * @param string $scope
     *
     * @return RuntimeCacheInterface
     */
    public function setScope($scope = null);

    /**
     * Retrieve the current runtime cache scope.
     *
     * @return string
     */
    public function getScope();

    /**
     * Switches RuntimeCache scope back to global
     *
     * @return RuntimeCacheInterface
     */
    public function clearScope();

    /**
     * @param string $key
     * @param string $scope
     *
     * @return boolean
     */
    public function has($key, $scope = null);

    /**
     * @param string $key
     * @param string $scope
     *
     * @return mixed
     */
    public function get($key, $scope = null);

    /**
     * @param string $key
     * @param mixed  $value
     * @param string $scope
     *
     * @return RuntimeCacheInterface
     */
    public function set($key, $value, $scope = null);

    /**
     * @param string $key
     * @param string $scope
     *
     * @return RuntimeCacheInterface
     */
    public function remove($key, $scope = null);
}

