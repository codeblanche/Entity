<?php

namespace EntityMarshal\Marshal;

class StubTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Stub
     */
    protected $obj;

    public function testRatify()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify('someProperty', 'string', $expected, true);

        $this->assertEquals($expected, $actual);
    }

    public function testRatifyNoException()
    {
        $expected = 'someValue';
        $actual   = $this->obj->ratify('someProperty', 'string', $expected, false);

        $this->assertEquals($expected, $actual);
    }

    protected function setUp()
    {
        $this->obj = new Stub();
    }
}
