<?php

namespace EntityMarshal\Converter;

use EntityMarshal\Converter\Exception\RuntimeException;

class PhpArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    protected $expected = array(
        'testBool'          => false,
        'testBoolean'       => true,
        'testInteger'       => 12345,
        'testInt'           => 67890,
        'testFloat'         => 12.123,
        'testDouble'        => 34.345,
        'testNumeric'       => 34567,
        'testLong'          => 23456,
        'testReal'          => 56.567,
        'testResource'      => null,
        'testScalar'        => 'make it count! make it scalar!',
        'testString'        => 'When life throws you a bone. Chew it.',
        'testMixed'         => 'This could be anything really',
        'testArray'         => array(0 => 'one', 1 => 2, 2 => 'three',),
        'testStdClass'      => null,
        'testEntityMarshal' => null,
        'testObject'        => array(),
        'testNull'          => null,
        'testCallable'      => array(0 => '\\EntityMarshal\\ForeignScope', 1 => 'getInstance',),
        'testTypedArray1'   => array(),
        'testTypedArray2'   => array(),
        'testTypedArray3'   => array(
            0 => array(0 => 'one', 1 => 2, 2 => 'three',),
            1 => array(0 => 'four', 1 => 5, 2 => 'six',),
        ),
        'testTypedArray4'   => array(
            0 => 2,
            1 => 3,
            2 => 5,
            3 => 7,
            4 => 11,
            5 => 13,
            6 => 17,
            7 => 19,
            8 => 23,
            9 => 29,
        ),
    );

    public function testConvert()
    {
        $this->assertEquals($this->expected, $this->obj->convert(new PhpArray(true)));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testCircularReferenceException()
    {
        // setup a circular reference
        $this->obj->testEntityMarshal = $this->obj;

        $this->obj->convert(new PhpArray(false));
    }

    public function testStandardObject()
    {
        $stdObj        = new \stdClass();
        $stdObj->prop1 = 'property 1';
        $stdObj->prop2 = 'property 2';
        $stdObj->propn = 'property n';

        $this->obj->setTestObject($stdObj);

        $arr = $this->obj->convert(new PhpArray(true));

        $this->assertArrayHasKey('testObject', $arr);

        $this->assertEquals(get_object_vars($stdObj), $arr['testObject']);
    }

    public function testCircularReferenceGraceful()
    {
        // setup a circular reference
        $this->obj->testEntityMarshal = $this->obj;

        $arr = $this->obj->convert(new PhpArray(true));

        $this->assertArrayHasKey('testEntityMarshal', $arr);

        $this->assertEquals(null, $arr['testEntityMarshal']);
    }

    protected function setUp()
    {
        $this->obj = new \MortadellaEntity();
    }
}
