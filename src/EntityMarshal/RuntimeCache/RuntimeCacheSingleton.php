<?php

namespace EntityMarshal\RuntimeCache;

final class RuntimeCacheSingleton implements RuntimeCacheSingletonInterface
{
    const SCOPE_DEFAULT = 'global';

    /**
     * @var RuntimeCacheInterface Singleton instance.
     */
    protected static $instance;

    /**
     * {@inheritdoc}
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new RuntimeCache();
        }

        return self::$instance;
    }
}

