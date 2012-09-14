<?php

namespace EntityMarshalTest;

use ArrayObject;
use EntityMarshal\AbstractEntity;
use PHPUnit_Framework_TestCase;

class AbstractEntityTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractEntity
     */
    private $stub;

    protected function setUp() {
        parent::setUp();

        /* @var $stub PHPUnit_Framework_MockObject_MockObject */

        $stub = $this->getMockForAbstractClass(
            '\EntityMarshal\AbstractEntity',
            array($this->getSampleDataArray())
        );

        $stub->expects($this->any())
            ->method('calledClassName')
            ->will($this->returnValue('AbstractEntityStub'));

        $this->stub = $stub;
    }

    protected function getSampleDataArray()
    {
        return array(
            'var1' => 'test1',
            'var2' => 'test2',
            'var3' => 'test3',
        );
    }

    public function testDump()
    {
        $this->expectOutputRegex('/.+/');

        $this->stub->dump();
    }

    public function testFromArray()
    {
        $this->stub->fromArray($this->getSampleDataArray());
    }

    public function testFromArrayWithTraversable()
    {
        $this->stub->fromArray(new ArrayObject($this->getSampleDataArray()));
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidFromArray()
    {
        $this->stub->fromArray('This is not an array');
    }

    /**
     * @depends testFromArray
     */
    public function testGetter()
    {
        $data     = $this->getSampleDataArray();

        $this->stub->fromArray($data);

        $expected = $data['var1'];
        $actual   = $this->stub->get('var1');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends testFromArray
     */
    public function testToArray()
    {
        $expected = $this->getSampleDataArray();
        $actual   = $this->stub->toArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends testGetter
     * @depends testToArray
     */
    public function testSetter()
    {
        $this->stub->set('lumpy', 'custard');

        $data = $this->stub->toArray();

        $this->assertEquals('custard', $data['lumpy']);
    }

    public function testIsset()
    {
        $this->assertFalse(isset($this->stub->notset));
        $this->assertTrue(isset($this->stub->var1));
    }

    /**
     * @depends testIsset
     */
    public function testUnset()
    {
        unset($this->stub->var1);

        $this->assertFalse(isset($this->stub->var1));
    }

    /**
     * @depends testFromArray
     */
    public function testIterable()
    {
        $data = $this->getSampleDataArray();

        $this->stub->fromArray($data);

        foreach ($this->stub as $key => $actual) {
            $expected = $data[$key];

            $this->assertEquals($expected, $actual);
        }
    }

    /**
     * @depends testFromArray
     * @depends testToArray
     */
    public function testSerializable()
    {
        $data = $this->getSampleDataArray();

        $this->stub->fromArray($data);

        $serialized = serialize($this->stub);

        $actual = unserialize($serialized);

        $this->assertEquals($this->stub, $actual);
    }

    /**
     * @depends testFromArray
     */
    public function testCountable()
    {
        $data = $this->getSampleDataArray();

        $this->stub->fromArray($data);

        $expected = count($data);
        $actual   = count($this->stub);

        $this->assertEquals($expected, $actual);

    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testtNonExistentProperty()
    {
        $this->stub->get('bacon');
    }
}