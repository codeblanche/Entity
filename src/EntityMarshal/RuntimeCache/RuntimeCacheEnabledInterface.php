<?php

namespace EntityMarshal\RuntimeCache;

interface RuntimeCacheEnabledInterface
{

    /**
     * Get the runtime cache instance.
     *
     * @return RuntimeCacheInterface
     */
    public function getRuntimeCache();

}
