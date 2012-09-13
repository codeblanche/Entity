<?php

namespace EntityMarshal\RuntimeCache;

interface RuntimeCacheEnabledInterface
{

    public function getRuntimeCache();

    public function setRuntimeCache($cache);

}
