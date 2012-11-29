<?php

namespace EntityMarshal\RuntimeCache;

interface RuntimeCacheSingletonInterface
{
    /**
     * @return RuntimeCacheInterface
     */
    public static function getInstance();
}

