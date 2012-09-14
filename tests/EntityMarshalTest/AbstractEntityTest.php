<?php

namespace EntityMarshalTest;

use ArrayObject;
use PHPUnit_Framework_TestCase;

class AbstractEntityTest extends PHPUnit_Framework_TestCase
{

    private $stub;

    protected function setUp() {
        parent::setUp();

        $this->stub = $this->getMockForAbstractClass('\EntityMarshal\AbstractEntity');
        $this->stub->expects($this->any())
            ->method('calledClassName')
            ->will($this->returnValue('AbstractEntityStub'));
    }

    public function testDump()
    {
        $this->expectOutputRegex('/.+/');

        $this->stub->dump();
    }

    public function testFromArray()
    {
        $this->stub->fromArray(array(
            'var1' => 'test1',
            'var2' => 'test2',
            'var3' => 'test3',
        ));
    }

    public function testFromArrayWithTraversable()
    {
        $this->stub->fromArray(new ArrayObject(array(
            'var1' => 'test1',
            'var2' => 'test2',
            'var3' => 'test3',
        )));
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
    public function testToArray()
    {
        $this->markTestIncomplete();
    }

    public function testIsset()
    {
        $this->markTestIncomplete();
    }

    public function testUnset()
    {
        $this->markTestIncomplete();
    }

    public function testIterable()
    {
        $this->markTestIncomplete();
    }

    public function testSerializable()
    {
        $this->markTestIncomplete();
    }

    public function testCountable()
    {
        $this->markTestIncomplete();
    }

// Cannot test this here
//    /**
//     * @expectedException \EntityMarshal\Exception\RuntimeException
//     */
//    public function getNonExistentProperty()
//    {
//        $stub = $this->getAbstractEntityStub();
//        $stub->
//    }
}