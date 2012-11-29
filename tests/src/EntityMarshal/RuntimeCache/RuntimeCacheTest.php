<?php

namespace EntityMarshal\RuntimeCache;

/**
 * Description of RuntimeCacheTest
 *
 * @author merten
 */
class RuntimeCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RuntimeCacheInterface
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * @return RuntimeCacheInterface
     */
    public function testConstructor()
    {
        if (is_null($this->object)) {
            $this->object = new RuntimeCache();
        }

        return $this->object;
    }

    /**
     * @depends testConstructor
     */
    public function testGetScope(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $object->getScope()
        );
    }

    /**
     * @depends testConstructor
     */
    public function testSetScope(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            $object,
            $object->setScope(__CLASS__)
        );

        $this->assertEquals(
            __CLASS__,
            $object->getScope()
        );
    }


    /**
     * @depends testConstructor
     */
    public function testClearScope(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            $object,
            $object->setScope()
        );

        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $object->getScope()
        );

        $object->setScope(__CLASS__);

        $this->assertEquals(
            __CLASS__,
            $object->getScope()
        );

        $this->assertEquals(
            $object,
            $object->clearScope()
        );

        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $object->getScope()
        );
    }

    /**
     * @depends testConstructor
     */
    public function testSet(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $object->getScope()
        );

        $this->assertEquals(
            $object,
            $object->set('testSet', 'in the middle of the night')
        );

        $this->assertEquals(
            $object,
            $object->set('testSet', 'i\'ll be walking in my sleep', __CLASS__)
        );
    }

    /**
     * @depends testConstructor
     */
    public function testGet(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            'in the middle of the night',
            $object->get('testSet')
        );

        $this->assertEquals(
            'i\'ll be walking in my sleep',
            $object->get('testSet', __CLASS__)
        );
    }

    /**
     * @depends testConstructor
     */
    public function testHas(RuntimeCacheInterface $object)
    {
        $this->assertTrue($object->has('testSet'));

        $this->assertTrue($object->has('testSet', __CLASS__));

        $this->assertFalse($object->has('bacon'));
    }

    /**
     * @depends testConstructor
     */
    public function testRemove(RuntimeCacheInterface $object)
    {
        $this->assertEquals(
            $object,
            $object->remove('testSet')
        );

        $this->assertEquals(
            $object,
            $object->remove('testSet', __CLASS__)
        );

        $this->assertFalse($object->has('testSet'));

        $this->assertFalse($object->has('testSet', __CLASS__));
    }

    /**
     * @depends testConstructor
     */
    public function testSerialize(RuntimeCacheInterface $object)
    {
        $object->set('testSerialize', 'on the global scope');
        $object->set('testSerialize', 'on the class scope', __CLASS__);

        $this->assertNotEmpty($cereal = serialize($object));

        return $cereal;
    }

    /**
     * @depends testSerialize
     */
    public function testUnserialize($cereal)
    {
        $object = unserialize($cereal);

        $this->assertTrue($object->has('testSerialize'));
        $this->assertTrue($object->has('testSerialize', __CLASS__));

        $this->assertEquals(
            'on the global scope',
            $object->get('testSerialize')
        );

        $this->assertEquals(
            'on the class scope',
            $object->get('testSerialize', __CLASS__)
        );
    }
}
