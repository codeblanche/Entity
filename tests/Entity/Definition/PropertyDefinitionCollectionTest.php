<?php

namespace Entity\Definition;

use Entity\Definition\Abstraction\PropertyDefinitionInterface;
use Entity\Exception\InvalidArgumentException;

class PropertyDefinitionCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyDefinitionCollection
     */
    protected $obj;

    /**
     * @var array
     */
    protected $props = array(
        'testBool'          => 'bool',
        'testBoolean'       => 'boolean',
        'testInteger'       => 'integer',
        'testInt'           => 'int',
        'testFloat'         => 'float',
        'testDouble'        => 'double',
        'testNumeric'       => 'numeric',
        'testLong'          => 'long',
        'testReal'          => 'real',
        'testResource'      => 'resource',
        'testScalar'        => 'scalar',
        'testString'        => 'string',
        'testMixed'         => 'mixed',
        'testArray'         => 'array',
        'testStdClass'      => '\\stdClass',
        'testEntityMarshal' => 'MortadellaEntity',
        'testObject'        => 'object',
        'testNull'          => 'null',
        'testCallable'      => 'callable',
        'testTypedArray1'   => 'MortadellaEntity[]',
        'testTypedArray2'   => 'array<MortadellaEntity>',
        'testTypedArray3'   => 'array[]',
        'testTypedArray4'   => 'integer[]',
    );

    public function testAddHasGet()
    {
        foreach ($this->props as $name => $type) {
            $this->assertEquals($this->obj, $this->obj->add($name, $type));
            $this->assertTrue($this->obj->has($name));
            $this->assertTrue($this->obj->get($name) instanceof PropertyDefinitionInterface);
        }
    }

    public function testKeys()
    {
        foreach ($this->props as $name => $type) {
            $this->obj->add($name, $type);
        }

        $this->assertEquals(array_keys($this->props), $this->obj->keys());
    }

    public function testImportExport()
    {
        foreach ($this->props as $name => $type) {
            $this->obj->add($name, $type);
        }

        $export = $this->obj->export();

        $this->assertEquals($this->props, $export);

        $this->obj->import($export);

        foreach ($this->props as $name => $type) {
            $this->assertTrue($this->obj->has($name));
            $this->assertTrue($this->obj->get($name) instanceof PropertyDefinitionInterface);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testImportException()
    {
        $this->obj->import(null);
    }

    protected function setUp()
    {
        $this->obj = new PropertyDefinitionCollection(new PropertyDefinition());
    }
}
