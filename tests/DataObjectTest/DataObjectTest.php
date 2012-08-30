<?php

namespace DataObjectTest;

use DataObjectTest\TestAsset\SampleDataObject;
use DataObjectTest\TestAsset\InvalidClassNameInDocType;
use DataObjectTest\TestAsset\InvalidMixedPropertyIdentifier;

class DataObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SampleDataObject
     */
    static protected $dataObject;

    static protected $recursionCount = 0;

    /**
     * Some test data
     * @return array
     */
    static protected function makeTestDataArray($recursionLimit = 1)
    {
        $stdObj = new \StdClass();
        $stdObj->testBool = true;

        if (static::$recursionCount < $recursionLimit) {
            static::$recursionCount++;
            $dataObj = new SampleDataObject(static::makeTestDataArray($recursionLimit));

        } else {
            $dataObj = new SampleDataObject();
        }

        return array (
            'testBool' => false,
            'testBoolean' => true,
            'testInteger' => 52545,
            'testInt' => 87898,
            'testFloat' => 13.123,
            'testDouble' => 35.345,
            'testNumeric' => 54565,
            'testLong' => 43454,
            'testReal' => 57.567,
            'testResource' => null,
            'testScalar' => 'test scalar',
            'testString' => 'test string',
            'testMixed' => null,
            'testArray' => array ('1', '2', '3'),
            'testStdClass' => $stdObj,
            'testDataObject' => $dataObj,
            'testObject' => $stdObj,
            'testNull' => null,
            'testCallable' => array('DataObjectIndex', 'testCallable'),
        );
    }

    static protected function makeSampleDataObject($recursionLimit = 1)
    {
        static::$recursionCount = 0;
        $dataObj = new SampleDataObject(static::makeTestDataArray($recursionLimit));

        return $dataObj;
    }

    public static function setUpBeforeClass()
    {
        static::$dataObject = static::makeSampleDataObject();
    }

    public function testSetValidInteger()
    {
        static::$dataObject->testInteger = 13;
        $this->assertEquals(13, static::$dataObject->testInteger);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidInteger()
    {
        static::$dataObject->testInteger = 'im_invalid';
    }

    public function testSetValidString()
    {
        static::$dataObject->testString = 'im_a_string';
        $this->assertEquals('im_a_string', static::$dataObject->testString);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidString()
    {
        static::$dataObject->testString = array('This is an array');
        exit;
    }

    public function testSetValidArray()
    {
        static::$dataObject->testArray = array('This is an array');
        $this->assertInternalType('array', static::$dataObject->testArray);
        $this->assertArrayHasKey(0, static::$dataObject->testArray);
        $this->assertEquals('This is an array', static::$dataObject->testArray[0]);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidArray()
    {
        static::$dataObject->testArray = 'im_a_string';
    }

    public function testSetValidObject()
    {
        static::$dataObject->testObject = static::$dataObject;
        $this->assertInstanceOf('\DataObjectTest\TestAsset\SampleDataObject', static::$dataObject->testObject);
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testSetInvalidObject()
    {
        static::$dataObject->testObject = 123;
    }

    public function testSetMixed()
    {
        static::$dataObject->testMixed = 13;
        $this->assertEquals(13, static::$dataObject->testMixed);

        static::$dataObject->testMixed = 'im_a_string';
        $this->assertEquals('im_a_string', static::$dataObject->testMixed);

        static::$dataObject->testMixed = array('This is an array');
        $this->assertInternalType('array', static::$dataObject->testMixed);
        $this->assertArrayHasKey(0, static::$dataObject->testMixed);
        $this->assertEquals('This is an array', static::$dataObject->testMixed[0]);

        static::$dataObject->testMixed = static::makeSampleDataObject();
        $this->assertInstanceOf('\DataObjectTest\TestAsset\SampleDataObject', static::$dataObject->testMixed);
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
        unset(static::$dataObject->idoesnotexists);
    }

    public function testSerialize()
    {
        $serialize = static::$dataObject->serialize();
        $this->assertNotEquals(false, @unserialize($serialize));
    }

    public function testUnSerialize()
    {
        $serialize = static::$dataObject->serialize();
        $this->assertInstanceOf('\DataObjectTest\TestAsset\SampleDataObject', static::$dataObject->unserialize($serialize));
    }

    public function testExport()
    {
        $this->assertInternalType('array', static::$dataObject->export());
    }

    public function testJSON()
    {
//        $json = static::$dataObject->json();
//        $this->assertNotEquals(false, json_decode($json));
    }

    public function testImport()
    {
        $export = static::$dataObject->export();
        static::$dataObject->import($export);
    }

    public function testExportCache()
    {
        $this->assertNotEquals(false, @unserialize(static::$dataObject->ExportCache()));
    }

    public function testImportCache()
    {
        $serialized = static::$dataObject->ExportCache();
        $this->assertEquals(true, static::$dataObject->ImportCache($serialized));
    }

    /**
    * @expectedException \DataObject\Exception\RuntimeException
    */
    public function testImportCacheInvalid()
    {
        $serialize = 'im not a serialized thing';
        static::$dataObject->ImportCache($serialize);
    }

    public function testQueryString()
    {
        return;
        $string = static::$dataObject->queryString();
        $data = array();
        parse_str($string, $data);

        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data);
    }

}






