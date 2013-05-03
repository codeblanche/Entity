<?php

namespace EntityMarshal\Converter;

class HashTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    /**
     * @var \EmptyEntity
     */
    protected $obj2;

    public function testConvert()
    {
        $this->assertNotEmpty($this->obj->convert(new Hash()));

        $this->assertNotEmpty($this->obj->convert(new Hash(Hash::HASH_TYPE_SHA256, '', '', array('testBool'))));

        $this->assertNotEmpty($this->obj2->convert(new Hash()));

        $this->assertNotEmpty($this->obj2->convert(new Hash(Hash::HASH_TYPE_SHA256, '', '', array('testBool'))));
    }

    protected function setUp()
    {
        $this->obj  = new \MortadellaEntity();
        $this->obj2 = new \EmptyEntity();
    }
}
