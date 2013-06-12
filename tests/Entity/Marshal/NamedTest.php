<?php

namespace Entity\Marshal;

use Entity\Definition\PropertyDefinition;
use Entity\Marshal\Exception\InvalidArgumentException;

class NamedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Named
     */
    protected $obj;

    /**
     * @var PropertyDefinition
     */
    protected $definition;

    public function testRatify()
    {
        $expected = 'someValue';

        $actual = $this->obj->ratify($expected, $this->definition);

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
        $this->obj        = new Named();
        $this->definition = new PropertyDefinition();

        $this->definition->setName('someProperty')->setRawType('string');
    }
}
