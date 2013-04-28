<?php

namespace EntityMarshal;

use EntityMarshal\Exception\RuntimeException;

class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MortadellaEntity
     */
    protected $obj;

    /**
     * @var \NoDocEntity
     */
    protected $obj2;

    public function testCalledClassName()
    {
        $this->assertEquals('MortadellaEntity', $this->obj->calledClassName());
    }

    public function testMagicSetterGetter()
    {
        $expected = 'this is some random test string';

        $this->obj->testString = $expected;

        $this->assertEquals($expected, $this->obj->testString);
    }

    public function testMagicCall()
    {
        $expected = 'this is another random test string';

        $this->obj->setTestString($expected);

        $this->assertEquals($expected, $this->obj->getTestString());
    }

    public function testConstructorDataInjection()
    {
        /** @noinspection PhpParamsInspection */
        $ent = new \MortadellaEntity(array(
            'testString' => 'When bacon is not an option. Use mortadella.',
        ));

        $this->assertEquals('When bacon is not an option. Use mortadella.', $ent->testString);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testConstructorDataInjectionFail()
    {
        /** @noinspection PhpParamsInspection */
        $ent = new \MortadellaEntity('When bacon is not an option. Use mortadella.');

        $this->assertEquals('When bacon is not an option. Use mortadella.', $ent->testString);
    }

    public function testDump()
    {
        $this->expectOutputRegex('/^<pre style=\'color:#555;\'>/');

        $this->obj->dump(true);
    }

    public function testSerializeUnserialize()
    {
        $serialized = serialize($this->obj);

        $unserialized = unserialize($serialized);

        $this->assertTrue($unserialized instanceof \MortadellaEntity);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetNonExistentProperty()
    {
        // attempt to retrieve non existent property.
        // Don't fix this.
        $this->obj->tstBoolean;
    }

    public function testCallingNonExistentMethod()
    {
        // attempt to call non existent method.
        // Don't fix this.
        $result = $this->obj->callSomeNonExistentMethod();

        $this->assertNull($result);
    }

    public function testBooleanIsMethod()
    {
        $ent = new \IsEntity();

        $ent->isTrue = true;

        $this->assertTrue($ent->isTrue());
    }

    public function testClone()
    {
        $newObj = clone $this->obj;

        $this->assertTrue($newObj instanceof \MortadellaEntity);
    }

    public function testIsset()
    {
        $this->assertTrue(isset($this->obj->testBool));
        $this->assertFalse(isset($this->obj->tstBoolean));
    }

    public function testUnset()
    {
        unset($this->obj->testBool);

        $this->assertFalse(isset($this->obj->testBool));
    }

    public function testTypeof()
    {
        $this->assertEquals('', $this->obj2->typeof('testString'));

        $this->assertEquals('string', $this->obj->typeof('testString'));

        $this->assertEquals('', $this->obj->typeof('nonExistentProperty'));
    }

    protected function setUp()
    {
        $this->obj  = new \MortadellaEntity();
        $this->obj2 = new \NoDocEntity();
    }
}
