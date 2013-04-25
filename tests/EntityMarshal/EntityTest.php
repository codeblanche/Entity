<?php

namespace EntityMarshal;

require '../fixtures/MortadellaEntity.php';

class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    public function testCalledClassName()
    {
        $this->assertEquals('MortadellaEntity', $this->obj->calledClassName());
    }

    public function testMagicSetterGetter()
    {
        $expected = 'this is some random test string';

        $this->obj->testString = $expected;

        $this->assertEquals($expected, $this->obj->testString);
    }

    public function testMagicCall()
    {
        $expected = 'this is another random test string';

        $this->obj->setTestString($expected);

        $this->assertEquals($expected, $this->obj->getTestString());
    }

    protected function setUp()
    {
        $this->obj = new \MortadellaEntity();
    }
}
