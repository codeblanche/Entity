<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\PropertyDefinition;
use EntityMarshal\Marshal\Exception\InvalidArgumentException;
use EntityMarshal\Marshal\Exception\LogicException;
use EntityMarshal\Marshal\Exception\RuntimeException;

class StrictTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Strict
     */
    protected $obj;

    /**
     * @var PropertyDefinition
     */
    protected $stringDefinition;

    /**
     * @var PropertyDefinition
     */
    protected $integerDefinition;

    /**
     * @var PropertyDefinition
     */
    protected $gookDefinition;

    /**
     * @var PropertyDefinition
     */
    protected $entityDefinition;

    public function testRatify()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify($expected, $this->stringDefinition);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRatifyException()
    {
        $this->obj->ratify('someValue', null);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRatifyRuntimeException()
    {
        $this->obj->ratify(12.12345, $this->integerDefinition);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRatifyRuntimeExceptionAgain()
    {
        $this->obj->ratify('asdd', $this->entityDefinition);
    }

    /**
     * @expectedException LogicException
     */
    public function testRatifyLogicException()
    {
        $this->obj->ratify('gobbledy', $this->gookDefinition);
    }

    protected function setUp()
    {
        $this->obj               = new Strict();
        $this->stringDefinition  = new PropertyDefinition();
        $this->integerDefinition = new PropertyDefinition();
        $this->gookDefinition    = new PropertyDefinition();
        $this->entityDefinition  = new PropertyDefinition();

        $this->stringDefinition->setName('someProperty')->setRawType('string');
        $this->integerDefinition->setName('someIntegerProperty')->setRawType('integer');
        $this->gookDefinition->setName('someGookProperty')->setRawType('gook');
        $this->entityDefinition->setName('someEntityProperty')->setRawType('MortadellaEntity');
    }
}
