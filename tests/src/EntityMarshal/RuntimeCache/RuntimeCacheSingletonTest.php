<?php

namespace EntityMarshal\RuntimeCache;

require_once dirname(__FILE__) . '/../../../../src/EntityMarshal/RuntimeCache/RuntimeCacheSingleton.php';

/**
 * Test class for RuntimeCacheSingleton.
 * Generated by PHPUnit on 2012-09-23 at 21:46:46.
 */
class RuntimeCacheSingletonTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RuntimeCacheSingleton
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = RuntimeCacheSingleton::getInstance();
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::getInstance
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::__construct
     * @todo Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $this->object = RuntimeCacheSingleton::getInstance();

        $this->assertInstanceOf(
            '\EntityMarshal\RuntimeCache\RuntimeCacheSingleton',
            $this->object
        );
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::getScope
     */
    public function testGetScope()
    {
        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $this->object->getScope()
        );
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::setScope
     */
    public function testSetScope()
    {
        $this->assertEquals(
            $this->object,
            $this->object->setScope(__CLASS__)
        );

        $this->assertEquals(
            __CLASS__,
            $this->object->getScope()
        );
    }


    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::clearScope
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::setScope
     */
    public function testClearScope()
    {
        $this->assertEquals(
            $this->object,
            $this->object->setScope()
        );

        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $this->object->getScope()
        );

        $this->object->setScope(__CLASS__);

        $this->assertEquals(
            __CLASS__,
            $this->object->getScope()
        );

        $this->assertEquals(
            $this->object,
            $this->object->clearScope()
        );

        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $this->object->getScope()
        );
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::set
     */
    public function testSet()
    {
        $this->assertEquals(
            RuntimeCacheSingleton::SCOPE_DEFAULT,
            $this->object->getScope()
        );

        $this->assertEquals(
            $this->object,
            $this->object->set('testSet', 'in the middle of the night')
        );

        $this->assertEquals(
            $this->object,
            $this->object->set('testSet', 'i\'ll be walking in my sleep', __CLASS__)
        );
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::get
     */
    public function testGet()
    {
        $this->assertEquals(
            'in the middle of the night',
            $this->object->get('testSet')
        );

        $this->assertEquals(
            'i\'ll be walking in my sleep',
            $this->object->get('testSet', __CLASS__)
        );
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::has
     */
    public function testHas()
    {
        $this->assertTrue($this->object->has('testSet'));

        $this->assertTrue($this->object->has('testSet', __CLASS__));

        $this->assertFalse($this->object->has('bacon'));
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::remove
     */
    public function testRemove()
    {
        $this->assertEquals(
            $this->object,
            $this->object->remove('testSet')
        );

        $this->assertEquals(
            $this->object,
            $this->object->remove('testSet', __CLASS__)
        );

        $this->assertFalse($this->object->has('testSet'));

        $this->assertFalse($this->object->has('testSet', __CLASS__));
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::serialize
     */
    public function testSerialize()
    {
        $this->object->set('testSerialize', 'on the global scope');
        $this->object->set('testSerialize', 'on the class scope', __CLASS__);

        $this->assertNotEmpty($cereal = serialize($this->object));

        return $cereal;
    }

    /**
     * @covers EntityMarshal\RuntimeCache\RuntimeCacheSingleton::unserialize
     * @depends testSerialize
     */
    public function testUnserialize($cereal)
    {
        $this->object = unserialize($cereal);

        $this->assertTrue($this->object->has('testSerialize'));
        $this->assertTrue($this->object->has('testSerialize', __CLASS__));

        $this->assertEquals(
            'on the global scope',
            $this->object->get('testSerialize')
        );

        $this->assertEquals(
            'on the class scope',
            $this->object->get('testSerialize', __CLASS__)
        );
    }

}


