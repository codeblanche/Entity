<?php

namespace EntityMarshal;

use ConcreteMarshaledEntity;
use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../../../src/EntityMarshal/AbstractMarshaledEntity.php';
require_once __DIR__ . '/../../_files/DynamicConcreteMarshaledEntity.php';
require_once __DIR__ . '/../../_files/ConcreteMarshaledEntity.php';
require_once __DIR__ . '/../../_files/ConcreteEntity.php';
require_once __DIR__ . '/../../_files/InvalidConcreteMarshaledEntityA.php';
require_once __DIR__ . '/../../_files/InvalidConcreteMarshaledEntityB.php';
require_once __DIR__ . '/../../_files/InvalidConcreteMarshaledEntityC.php';

/**
 * Test class for AbstractMarshaledEntity.
 * Generated by PHPUnit on 2012-09-23 at 21:46:45.
 */
class AbstractMarshaledEntityTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ConcreteMarshaledEntity
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ConcreteMarshaledEntity($this->getSampleDataArray());
    }

    protected function getSampleDataArray()
    {
        return array(
            'isOk' => true,
            'var1' => '1.234',
            'var2' => '1234',
            'var3' => 'test3',
            'var4' => 'test4',
            'gen1' => null,
            'gen2' => null,
            'ent1' => null,
            'obj1' => null,
            'arr1' => null,
            'obj2' => null,
            'nil1' => null,
        );
    }

    protected function getSampleTypesArray()
    {
        return array(
            'isOk' => 'boolean',
            'var1' => 'float',
            'var2' => 'integer',
            'var3' => 'string',
            'var4' => null,
            'gen1' => 'string[]',
            'gen2' => 'array<string>',
            'ent1' => '\ConcreteEntity',
            'obj1' => '\stdClass',
            'arr1' => 'array',
            'obj2' => 'object',
            'nil1' => 'null',
        );
    }

    public function testConstruct()
    {
        $data = $this->getSampleDataArray();

        $data['anExtraValue'] = 'should be ignored';

        $this->object = new ConcreteMarshaledEntity($data);

        $this->assertNotEmpty($this->object);
    }

    public function testReflectProperties()
    {
        $actual = $this->object->triggerReflectProperties(\ReflectionProperty::IS_PUBLIC);
        $expected = $this->getSampleTypesArray();
        $this->assertEquals($expected, $actual);
    }

    public function testSerialize()
    {
        $cereal = serialize($this->object);

        $newObj = unserialize($cereal);

        $this->assertEquals($this->object, $newObj);
    }

    public function testTypeof()
    {
        $types = $this->getSampleTypesArray();

        foreach ($types as $name => $expected) {
            $actual = $this->object->typeof($name);

            if (is_null($expected)) {
                $expected = 'mixed';
            }

            $matches = array();
            if(preg_match('/array<(?<type>[^>]+)>/', $expected, $matches)) {
                $expected = "{$matches['type']}[]";
            }

            $this->assertEquals($expected, $actual, "Expected '$name' to be a '$expected'.");
        }
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidMixedType()
    {
        $obj = new \InvalidConcreteMarshaledEntityA();
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidGenericsType()
    {
        $obj = new \InvalidConcreteMarshaledEntityB();
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidType()
    {
        $obj = new \InvalidConcreteMarshaledEntityC();
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidSet()
    {
        $this->object->set('nonExistant', 'Some random value');
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testInvalidFromArray()
    {
        $this->object->fromArray('WTF! this is not an array?!?!');
    }

    public function testTypeofNonExistant()
    {
        $type = $this->object->typeof('nonExistant');

        $this->assertEquals('mixed', $type);
    }

    public function testFromArray()
    {
        $data = $this->getSampleDataArray();
        unset($data['var3']);
        $this->object->fromArray($data);

        $data['var3'] = null;

        $actual   = $this->object->toArray();
        $expected = $data;

        $this->assertEquals($expected, $actual);
    }

    public function testGenericSet()
    {
        $this->object->set('gen1', array('abc', 'def', 123));
        $this->assertEquals(array('abc', 'def', '123'), $this->object->get('gen1'));
    }

    public function testEmptyValue()
    {
        $this->object->set('var3', '');

        $this->assertEmpty($this->object->get('var3'));
    }

    public function testSetEntityWithArray()
    {
        $this->object->set(
            'ent1',
            array(
                'isOk' => true,
                'var1' => 'test1',
                'var2' => 'test2',
                'var3' => 'test3',
            )
        );

        $this->assertInstanceOf('\ConcreteEntity', $this->object->get('ent1'));
    }

    public function testSetObjectWithArray()
    {
        $this->object->set(
            'obj1',
            array(
                'isOk' => true,
                'var1' => 'test1',
                'var2' => 'test2',
                'var3' => 'test3',
            )
        );

        $this->assertInstanceOf('\stdClass', $this->object->get('obj1'));
    }

    /**
     * @expectedException \EntityMarshal\Exception\RuntimeException
     */
    public function testSetInvalidObjectType()
    {
        $this->object->set('ent1', $this->object);
    }

    public function testDynamicPropertySet()
    {
        $obj = new \DynamicConcreteMarshaledEntity();

        $obj->set('anyVar', 'to anything');
    }

    public function testSetArr1()
    {
        $data = new \ArrayObject();
        $data->t1 = 1234;
        $data->t2 = 'test string two';

        $this->object->set('arr1', (array) $data);
        $this->assertTrue(is_array($this->object->get('arr1')));
    }

    public function testSetObj2()
    {
        $this->object->set('obj2', array('val1', 'val2'));
        $this->assertInstanceOf('\stdClass', $this->object->get('obj2'));
    }

    public function testSetNil1()
    {
        $this->object->set('nil1', 0);
        $this->assertNull($this->object->get('nil1'));
    }
}

