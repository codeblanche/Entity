<?php

namespace Entity\Converter;

class DumpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    public function testConvert()
    {
        $this->assertNotEmpty($this->obj->convert(new Dump(true)));

        $this->assertNotEmpty($this->obj->convert(new Dump(true, 1)));

        // setup a circular reference
        $this->obj->testEntityMarshal = $this->obj;

        $this->assertNotEmpty($this->obj->convert(new Dump(true)));
    }

    protected function setUp()
    {
        $this->obj = new \MortadellaEntity();

        $this->obj->testEntityMarshal = new \MortadellaEntity();

        $this->obj->testTypedArray1 = array(
            new \MortadellaEntity(),
            new \MortadellaEntity(),
            new \MortadellaEntity(),
            new \stdClass(),
        );

        $stdObj        = new \stdClass();
        $stdObj->prop1 = 'property 1';
        $stdObj->prop2 = 'property 2';
        $stdObj->propn = 'property n';

        $this->obj->setTestObject($stdObj);
    }
}
