<?php

namespace UnitTest\DataObject;

use \UnitTest\DataObject\TestAsset\MyDataObject,
    \UnitTest\DataObject\TestAsset\InvalidClassNameInDocType,
    \UnitTest\DataObject\TestAsset\InvalidMixedPropertyIdentifier;

class DataObjectTest extends \PHPUnit_Framework_TestCase
{
    protected static $dataObject;

    public static function setUpBeforeClass()
    {
        self::$dataObject = new MyDataObject();
    }

    public function testSetValidInteger()
    {
        self::$dataObject->integer = 13;
        $this->assertEquals(13, self::$dataObject->integer);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidInteger()
    {
        self::$dataObject->integer = 'im_invalid';
    }

    public function testSetValidString()
    {
        self::$dataObject->string = 'im_a_string';
        $this->assertEquals('im_a_string', self::$dataObject->string);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidString()
    {
        self::$dataObject->string = array('This is an array');
        exit;
    }

    public function testSetValidArray()
    {
        self::$dataObject->array = array('This is an array');
        $this->assertInternalType('array', self::$dataObject->array);
        $this->assertArrayHasKey(0, self::$dataObject->array);
        $this->assertEquals('This is an array', self::$dataObject->array[0]);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidArray()
    {
        self::$dataObject->array = 'im_a_string';
    }

    public function testSetValidObject()
    {
        self::$dataObject->object = new MyDataObject();
        $this->assertInstanceOf('\UnitTest\DataObject\TestAsset\MyDataObject', self::$dataObject->object);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidObject()
    {
        self::$dataObject->object = 123;
    }

    public function testSetMixed()
    {
        self::$dataObject->mixed = 13;
        $this->assertEquals(13, self::$dataObject->mixed);

        self::$dataObject->mixed = 'im_a_string';
        $this->assertEquals('im_a_string', self::$dataObject->mixed);

        self::$dataObject->mixed = array('This is an array');
        $this->assertInternalType('array', self::$dataObject->mixed);
        $this->assertArrayHasKey(0, self::$dataObject->mixed);
        $this->assertEquals('This is an array', self::$dataObject->mixed[0]);

        self::$dataObject->mixed = new MyDataObject();
        $this->assertInstanceOf('\UnitTest\DataObject\TestAsset\MyDataObject', self::$dataObject->mixed);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testInvalidClassNameInDoctype()
    {
        $object = new InvalidClassNameInDocType();
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testInvalidMixedDefinationInDoctype()
    {
        $object = new InvalidMixedPropertyIdentifier();
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testUnsetUknownVariable()
    {
        unset(self::$dataObject->idoesnotexists);
    }

    public function testSerialize()
    {
        $serialize = self::$dataObject->serialize();
        $this->assertNotEquals(false, @unserialize($serialize));
    }

    public function testUnSerialize()
    {
        $serialize = self::$dataObject->serialize();
        $this->assertInstanceOf('\UnitTest\DataObject\TestAsset\MyDataObject', self::$dataObject->unserialize($serialize));
    }

    public function testExport()
    {
        $this->assertInternalType('array', self::$dataObject->export());
    }

    public function testJSON()
    {
        $json = self::$dataObject->json();
        $this->assertNotEquals(false, json_decode($json));
    }

    public function testImport()
    {
        $export = self::$dataObject->export();
        self::$dataObject->import($export); // import breaks any following exports.
    }

    public function testExportCache()
    {
        $this->assertNotEquals(false, @unserialize(self::$dataObject->ExportCache()));
    }

    public function testImportCache()
    {
        $serialized = self::$dataObject->ExportCache();
        $this->assertEquals(true, self::$dataObject->ImportCache($serialized));
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testImportCacheInvalid()
    {
        $serialize = 'im not a serialized thing';
        self::$dataObject->ImportCache($serialize);
    }

    public function testQueryString()
    {
        return;
        $string = self::$dataObject->queryString();
        $data = array();
        parse_str($string, $data);

        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data);
    }

}
