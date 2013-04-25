<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Marshal\Exception\InvalidArgumentException;

class StrictTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Strict
     */
    protected $obj;

    public function testRatify()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify('someProperty', 'string', $expected, true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRatifyException()
    {
        $this->obj->ratify('someProperty', 'string', 'someValue', false);
    }

    protected function setUp()
    {
        $this->obj = new Strict();
    }
}
