<?php

namespace EntityMarshal\RuntimeCache\Abstraction;

interface RuntimeCacheEnabledInterface
{
    /**
     * Get the runtime cache instance.
     *
     * @return RuntimeCacheInterfacee
     */
    public function getRuntimeCache();

    /**
     * Set the runtime cache instance.
     *
     * @param RuntimeCacheInterfacee $cache
     *
     * @return mixed
     */
    public function setRuntimeCache(RuntimeCacheInterfacee $cache);
}

