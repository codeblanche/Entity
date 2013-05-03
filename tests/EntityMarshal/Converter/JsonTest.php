<?php

namespace EntityMarshal\Converter;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    public function testConvert()
    {
        $this->assertNotEmpty($this->obj->convert(new Json()));
    }

    protected function setUp()
    {
        $this->obj = new \MortadellaEntity();
    }
}
