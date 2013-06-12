<?php

namespace Entity\Converter;

class QueryStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    public function testConvert()
    {
        $this->assertNotEmpty($this->obj->convert(new QueryString()));
    }

    public function testIgnoreKeys()
    {
        $result = $this->obj->convert(new QueryString(array('testEntityMarshal')));

        $this->assertNotEmpty($result);

        $this->assertNotContains('testEntityMarshal', $result);
    }

    protected function setUp()
    {
        $this->obj = new \MortadellaEntity();
    }
}
