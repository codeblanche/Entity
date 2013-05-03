<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\PropertyDefinition;

class TypedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Typed
     */
    protected $obj;

    /**
     * @var PropertyDefinition
     */
    protected $definition;

    public function testRatifyArrayWithNullItem()
    {
        $expected = array(
            'string1',
            'string2',
            null,
            'string3',
        );
        $actual   = $this->obj->ratify($expected, $this->createDefinition('testProperty', 'string[]'));

        $this->assertEquals($expected, $actual);
    }

    public function testRatifyArrayType()
    {
        $expected = array(
            'string1',
            'string2',
            null,
            'string3',
        );
        $actual   = $this->obj->ratify((object) $expected, $this->createDefinition('testProperty', 'array'));

        $this->assertEquals($expected, $actual);
    }

    public function testRatifyObjectType()
    {
        $expected = array(
            'string1',
            'string2',
            null,
            'string3',
        );
        $actual   = $this->obj->ratify($expected, $this->createDefinition('testProperty', 'object'));

        $this->assertTrue($actual instanceof \stdClass);
    }

    public function testRatify()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify($expected, $this->definition);

        $this->assertEquals($expected, $actual);
    }

    public function testRatifyNoException()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify($expected, null);

        $this->assertEquals($expected, $actual);
    }

    public function testRatifyGeneric()
    {
        $expected = 'a test string';

        $this->assertEquals(
            $expected,
            $this->obj->ratify($expected, $this->createDefinition('testProperty', 'string[]'))
        );
    }

    public function testRatifyClassTypes()
    {
        $this->assertTrue(
            $this->obj->ratify(
                array(),
                $this->createDefinition('testProperty', 'MortadellaEntity')
            ) instanceof \MortadellaEntity
        );

        $this->assertTrue(
            $this->obj->ratify(
                array('aProperty' => 'aValue'),
                $this->createDefinition('testProperty', 'stdClass')
            ) instanceof \stdClass
        );
    }

    /**
     * @param string $name
     * @param string $rawType
     *
     * @return PropertyDefinition
     */
    protected function createDefinition($name, $rawType)
    {
        $definition = new PropertyDefinition;

        $definition->setName($name)->setRawType($rawType);

        return $definition;
    }

    protected function setUp()
    {
        $this->obj        = new Typed();
        $this->definition = new PropertyDefinition();

        $this->definition->setName('someProperty')->setRawType('string');
    }
}
