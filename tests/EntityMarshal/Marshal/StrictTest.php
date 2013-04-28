<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\PropertyDefinition;
use EntityMarshal\Marshal\Exception\InvalidArgumentException;

class StrictTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Strict
     */
    protected $obj;

    /**
     * @var PropertyDefinition
     */
    protected $definition;

    public function testRatify()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify($expected, $this->definition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRatifyException()
    {
        $this->obj->ratify('someValue', null);
    }

    protected function setUp()
    {
        $this->obj = new Strict();
        $this->definition = new PropertyDefinition();

        $this->definition->setName('someProperty')->setRawType('string');
    }
}
