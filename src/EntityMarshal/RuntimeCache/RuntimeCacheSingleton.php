<?php

namespace EntityMarshal\RuntimeCache;

final class RuntimeCacheSingleton
{
    const SCOPE_DEFAULT = 'global';

    /**
     * @var RuntimeCache Singleton instance.
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

