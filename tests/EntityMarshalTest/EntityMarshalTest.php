<?php

namespace EntityMarshalTest;

use ObjectPropertyEntityMarshal;
use EntityMarshalTest\TestAsset\InvalidClassNameInDocType;
use EntityMarshalTest\TestAsset\InvalidMixedPropertyIdentifier;

class EntityMarshalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectPropertyEntityMarshal
     */
    static protected $entity;

    /**
     * Some test data
     * @return array
     */
    static protected function makeTestDataArray()
    {
        $stdObj            = new \StdClass();
        $stdObj->testBool  = true;

        $entity           = new ObjectPropertyEntityMarshal();

        return array (
            'testBool'              => false,
            'testBoolean'           => true,
            'testInteger'           => 52545,
            'testInt'               => 87898,
            'testFloat'             => 13.123,
            'testDouble'            => 35.345,
            'testNumeric'           => 54565,
            'testLong'              => 43454,
            'testReal'              => 57.567,
            'testResource'          => null,
            'testScalar'            => 'test scalar',
            'testString'            => 'test string',
            'testMixed'             => null,
            'testArray'             => array ('1', '2', '3'),
            'testStdClass'          => $stdObj,
            'testEntityMarshal'     => $entity,
            'testObject'            => $stdObj,
            'testNull'              => null,
            'testCallable'          => array(__CLASS__, 'testCallable'),
            'testTypedArray1'       => array($entity),
            'testTypedArray2'       => array(null, null),
            'testTypedArray3'       => array(array('1231231','asdasa',12312), array('1231231','asdasa',12312)),
            'testTypedArray4'       => array(12345, 23456, 34567, '1231'),
            'blah'                  => 1,
            'flunnieline'           => 'asdasassaas',
        );
    }

    static protected function makeSampleEntityMarshal($data = null)
    {
        return new ObjectPropertyEntityMarshal($data);
    }

    static public function testCallable()
    {
        // callable method
    }

    public static function setUpBeforeClass()
    {
        static::$entity = static::makeSampleEntityMarshal();
    }

    public function testSetValidInteger()
    {
        static::$entity->testInteger = 13;
        $this->assertEquals(13, static::$entity->testInteger);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetInvalidInteger()
    {
        static::$entity->testInteger = 'im_invalid';
    }

    public function testSetValidString()
    {
        static::$entity->testString = 'im_a_string';
        $this->assertEquals('im_a_string', static::$entity->testString);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetInvalidString()
    {
        static::$entity->testString = array('This is an array');
        exit;
    }

    public function testSetValidArray()
    {
        static::$entity->testArray = array('This is an array');
        $this->assertInternalType('array', static::$entity->testArray);
        $this->assertArrayHasKey(0, static::$entity->testArray);
        $this->assertEquals('This is an array', static::$entity->testArray[0]);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetInvalidArray()
    {
        static::$entity->testArray = 'im_a_string';
    }

    public function testSetValidObject()
    {
        static::$entity->testObject = static::makeSampleEntityMarshal();
        $this->assertInstanceOf('\ObjectPropertyEntityMarshal', static::$entity->testObject);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetInvalidObject()
    {
        static::$entity->testObject = 123;
    }

    public function testSetMixed()
    {
        static::$entity->testMixed = 13;
        $this->assertEquals(13, static::$entity->testMixed);

        static::$entity->testMixed = 'im_a_string';
        $this->assertEquals('im_a_string', static::$entity->testMixed);

        static::$entity->testMixed = array('This is an array');
        $this->assertInternalType('array', static::$entity->testMixed);
        $this->assertArrayHasKey(0, static::$entity->testMixed);
        $this->assertEquals('This is an array', static::$entity->testMixed[0]);

        static::$entity->testMixed = static::makeSampleEntityMarshal();
        $this->assertInstanceOf('\ObjectPropertyEntityMarshal', static::$entity->testMixed);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testInvalidClassNameInDoctype()
    {
        $object = new InvalidClassNameInDocType();
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testInvalidMixedDefinationInDoctype()
    {
        $object = new InvalidMixedPropertyIdentifier();
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testUnsetUknownVariable()
    {
        unset(static::$entity->idoesnotexists);
    }

    public function testSerialize()
    {
        $serialize = static::$entity->serialize();
        $this->assertNotEquals(false, @unserialize($serialize));
    }

    public function testUnserialize()
    {
        $serialize = static::$entity->serialize();
        $this->assertInstanceOf('\ObjectPropertyEntityMarshal', static::$entity->unserialize($serialize));
    }

    public function testExport()
    {
        $this->assertInternalType('array', static::$entity->export());
    }

    public function testJSON()
    {
        $json = static::$entity->json();
        $this->assertNotEquals(false, json_decode($json));
    }

    public function testImport()
    {
        $export = static::$entity->export();
        static::$entity->import($export);
    }

    public function testExportCache()
    {
        $this->assertNotEquals(false, @unserialize(static::$entity->ExportCache()));
    }

    public function testImportCache()
    {
        $serialized = static::$entity->ExportCache();
        $this->assertEquals(true, static::$entity->ImportCache($serialized));
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testImportCacheInvalid()
    {
        $serialize = 'im not a serialized thing';
        static::$entity->ImportCache($serialize);
    }

    public function testQueryString()
    {
        $string = static::$entity->queryString();
        $data = array();
        parse_str($string, $data);

        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data);
    }

    public function testSetScalarToEmptyString()
    {
        $properties = array (
            'testBool',
            'testBoolean',
            'testInteger',
            'testInt',
            'testFloat',
            'testDouble',
            'testLong',
            'testReal',
            'testScalar',
            'testString',
            'testNull',
        );

        $do = self::$entity;

        array_map(function ($key) use ($do) {
            $do->$key = '';
        }, $properties);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetArrayToEmptyString()
    {
        $properties = array (
            'testArray',
        );

        $do = self::$entity;

        array_map(function ($key) use ($do) {
            $do->$key = '';
        }, $properties);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetObjectToEmptyString()
    {
        $properties = array (
            'testStdClass',
            'testEntityMarshal',
            'testObject',
        );

        $do = self::$entity;

        array_map(function ($key) use ($do) {
            $do->$key = '';
        }, $properties);
    }

    /**
    * @expectedException \EntityMarshal\Exception\RuntimeException
    */
    public function testSetCallableToEmptyString()
    {
        $properties = array (
            'testCallable',
        );

        $do = self::$entity;

        array_map(function ($key) use ($do) {
            $do->$key = '';
        }, $properties);
    }

    public function testSetAllToNull()
    {
        $properties = array (
            'testBool',
            'testBoolean',
            'testInteger',
            'testInt',
            'testFloat',
            'testDouble',
            'testNumeric',
            'testLong',
            'testReal',
            'testResource',
            'testScalar',
            'testString',
            'testMixed',
            'testArray',
            'testStdClass',
            'testEntityMarshal',
            'testObject',
            'testNull',
            'testCallable',
            'testTypedArray1',
            'testTypedArray2',
            'testTypedArray3',
            'testTypedArray4',
        );

        $do = self::$entity;

        array_map(function ($key) use ($do) {
            $do->$key = null;
        }, $properties);

        $self = $this;

        array_map(function ($key) use ($do, $self) {
            $self->assertEquals(null, $do->$key);
        }, $properties);
    }

}
