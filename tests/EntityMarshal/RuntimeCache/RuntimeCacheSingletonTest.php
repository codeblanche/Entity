<?php

namespace EntityMarshal\RuntimeCache;

class RuntimeCacheSingletonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RuntimeCache
     */
    protected $obj;

    public function testSingleton()
    {
        $this->assertEquals($this->obj, RuntimeCacheSingleton::getInstance());
    }

    protected function setUp()
    {
        $this->obj = RuntimeCacheSingleton::getInstance();
    }
}
