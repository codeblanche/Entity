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
}

