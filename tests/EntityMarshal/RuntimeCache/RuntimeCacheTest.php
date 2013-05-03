<?php

namespace EntityMarshal\RuntimeCache;

class RuntimeCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RuntimeCache
     */
    protected $obj;

    public function testSetGetClearScope()
    {
        $scope = __CLASS__;

        $this->assertEquals($this->obj, $this->obj->setScope($scope));

        $this->assertEquals($scope, $this->obj->getScope());

        $this->assertEquals($this->obj, $this->obj->clearScope());

        $this->assertEquals(RuntimeCache::SCOPE_DEFAULT, $this->obj->getScope());

        $this->obj->setScope($scope);

        $this->assertEquals($scope, $this->obj->getScope());

        $this->obj->setScope(null);

        $this->assertEquals(RuntimeCache::SCOPE_DEFAULT, $this->obj->getScope());
    }

    public function testSetHasGetRemove()
    {
        $expected = 'some random value string';
        $key      = __METHOD__;

        $this->assertEquals($this->obj, $this->obj->set($key, $expected));

        $this->assertTrue($this->obj->has($key));

        $this->assertFalse($this->obj->has($key, __CLASS__));

        $this->assertEquals($expected, $this->obj->get($key));

        $this->assertNull($this->obj->get($key, __CLASS__));

        $this->assertEquals($this->obj, $this->obj->remove($key));

        $this->assertFalse($this->obj->has($key));

        $this->assertNull($this->obj->get($key));
     }

    public function testSerializeUnserialize()
    {
        $expected = 'some other random value string not unsimilar to the last random value string';
        $key      = __METHOD__;

        $this->obj->set($key, $expected);

        $serialized = serialize($this->obj);

        $this->assertNotEmpty($serialized);

        /**
         * @var $unserialized RuntimeCache
         */
        $unserialized = unserialize($serialized);

        $this->assertTrue($unserialized instanceof RuntimeCache);

        $this->assertEquals($expected, $unserialized->get($key));
    }

    protected function setUp()
    {
        $this->obj = new RuntimeCache();
    }
}
