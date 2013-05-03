<?php

namespace EntityMarshal\Definition;

class PropertyDefinitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyDefinition
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

    public function testGetSetName()
    {
        foreach ($this->props as $name => $type) {
            $tmp = clone $this->obj;

            $this->assertEquals($tmp, $tmp->setName($name));
            $this->assertEquals($name, $tmp->getName());

            unset($tmp);
        }
    }

    public function testGetSetRawType()
    {
        foreach ($this->props as $name => $type) {
            $tmp = clone $this->obj;

            $tmp->setName($name);

            $this->assertEquals($tmp, $tmp->setRawType($type));
            $this->assertEquals($type, $tmp->getRawType());

            unset($tmp);
        }
    }

    public function testGetSetType()
    {
        foreach ($this->props as $name => $type) {
            if ($this->isGeneric($type)) {
                $type = 'array';
            }

            $tmp = clone $this->obj;

            $tmp->setName($name);

            $this->assertEquals($tmp, $tmp->setType($type));
            $this->assertEquals($type, $tmp->getType());

            unset($tmp);
        }
    }

    public function testGetSetGenericType()
    {
        foreach ($this->props as $name => $type) {
            if ($this->isGeneric($type)) {
                $type = 'array';
            }

            $tmp = clone $this->obj;

            $tmp->setName($name);

            $this->assertEquals($tmp, $tmp->setGenericType($type));
            $this->assertEquals($type, $tmp->getGenericType());

            unset($tmp);
        }
    }

    protected function isGeneric($type)
    {
        return substr($type, -2) === '[]' || (strtolower(substr($type, 0, 6)) === 'array<' && substr(
            $type,
            -1
        ) === '>');
    }

    public function testIsGeneric()
    {
        foreach ($this->props as $name => $type) {
            $tmp = clone $this->obj;

            $tmp->setName($name);
            $tmp->setRawType($type);

            $this->assertEquals($this->isGeneric($type), $tmp->isGeneric());

            unset($tmp);
        }
    }

    public function testEmptyGenericType()
    {
        $tmp = clone $this->obj;
        $tmp->setName('testEmptyGeneric');
        $tmp->setRawType('array<>');

        $this->assertFalse($tmp->isGeneric());
        $this->assertEquals('array', $tmp->getType());

        $tmp->setRawType('');
        $this->assertEquals('', $tmp->getType());
        $this->assertEquals('', $tmp->getRawType());
    }

    protected function setUp()
    {
        $this->obj = new PropertyDefinition();
    }
}
