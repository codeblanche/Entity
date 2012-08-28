<?php

namespace DataObjectTest;

use DataObjectTest\TestAsset\MyDataObject;
use DataObjectTest\TestAsset\InvalidClassNameInDocType;
use DataObjectTest\TestAsset\InvalidMixedPropertyIdentifier;

class DataObjectTest extends \PHPUnit_Framework_TestCase
{
    protected static $dataObject;

    public static function setUpBeforeClass()
    {
        self::$dataObject = new MyDataObject();
    }

    public function testSetValidInteger()
    {
        self::$dataObject->testInteger = 13;
        $this->assertEquals(13, self::$dataObject->testInteger);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidInteger()
    {
        self::$dataObject->testInteger = 'im_invalid';
    }

    public function testSetValidString()
    {
        self::$dataObject->testString = 'im_a_string';
        $this->assertEquals('im_a_string', self::$dataObject->testString);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidString()
    {
        self::$dataObject->testString = array('This is an array');
        exit;
    }

    public function testSetValidArray()
    {
        self::$dataObject->testArray = array('This is an array');
        $this->assertInternalType('array', self::$dataObject->testArray);
        $this->assertArrayHasKey(0, self::$dataObject->testArray);
        $this->assertEquals('This is an array', self::$dataObject->testArray[0]);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidArray()
    {
        self::$dataObject->testArray = 'im_a_string';
    }

    public function testSetValidObject()
    {
        self::$dataObject->testObject = new MyDataObject();
        $this->assertInstanceOf('\DataObjectTest\TestAsset\MyDataObject', self::$dataObject->testObject);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidObject()
    {
        self::$dataObject->testObject = 123;
    }

    public function testSetMixed()
    {
        self::$dataObject->testMixed = 13;
        $this->assertEquals(13, self::$dataObject->testMixed);

        self::$dataObject->testMixed = 'im_a_string';
        $this->assertEquals('im_a_string', self::$dataObject->testMixed);

        self::$dataObject->testMixed = array('This is an array');
        $this->assertInternalType('array', self::$dataObject->testMixed);
        $this->assertArrayHasKey(0, self::$dataObject->testMixed);
        $this->assertEquals('This is an array', self::$dataObject->testMixed[0]);

        self::$dataObject->testMixed = new MyDataObject();
        $this->assertInstanceOf('\DataObjectTest\TestAsset\MyDataObject', self::$dataObject->testMixed);
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
        $this->assertInstanceOf('\DataObjectTest\TestAsset\MyDataObject', self::$dataObject->unserialize($serialize));
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
        self::$dataObject->import($export);
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






