<?php

require '../init.php';

//use DataObject\SampleDataObject;
use DataObject\Sample\ClassMethodDataObject as SampleClassMethodDataObject;
use Timer\Timer;

class IndexPage
{
    public function __construct()
    {
        $total = Timer::Make();

        static::setUpBeforeClass();

        $this->testCallable();
        $this->testExport();

        $methods = get_class_methods($this);

        $ignore = array (
            'testCallable',
            'testSetValidInteger',
            'testSetValidString',
            'testSetValidArray',
            'testSetValidObject',
            'testSetMixed',
            'testSerialize',
            'testUnserialize',
            'testExport',
            'testJSON',
//            'testImport',
            'testExportCache',
            'testImportCache',
            'testQueryString',
            'testSetScalarToEmptyString',
            'testSetAllToNull',
        );

        $filtered = array_filter($methods, function ($value) use ($ignore) {
            return substr($value, 0, 4) === 'test' && !in_array($value, $ignore);
        });

        var_dump('------------------------------------------------------');
        static::$dataObject->dump();

        foreach($filtered as $method) {
            $this->$method();
        }

        var_dump('------------------------------------------------------');
        static::$dataObject->dump();

        $total->stop();
        $total->dump();
    }

    public function __call($name, $arguments)
    {
        //;
    }


    /**
     * @var SampleClassMethodDataObject
     */
    static protected $dataObject;

    /**
     * Some test data
     * @return array
     */
    static protected function makeTestDataArray()
    {
        $stdObj            = new \StdClass();
        $stdObj->testBool  = true;

        $dataObj           = new SampleClassMethodDataObject;

        return array (
            'testBool'        => false,
            'testBoolean'     => true,
            'testInteger'     => 52545,
            'testInt'         => 87898,
            'testFloat'       => 13.123,
            'testDouble'      => 35.345,
            'testNumeric'     => 54565,
            'testLong'        => 43454,
            'testReal'        => 57.567,
            'testResource'    => null,
            'testScalar'      => 'test scalar',
            'testString'      => 'test string',
            'testMixed'       => null,
            'testArray'       => array ('1', '2', '3'),
            'testStdClass'    => $stdObj,
            'testDataObject'  => $dataObj,
            'testObject'      => $stdObj,
            'testNull'        => null,
            'testCallable'    => array(__CLASS__, 'testCallable'),
            'testTypedArray1' => array($dataObj),
            'testTypedArray2' => array(null, null),
            'testTypedArray3' => array(array('1231231','asdasa',12312), array('1231231','asdasa',12312)),
            'testTypedArray4' => array(12345, 23456, 34567, '1231'),
            'blah'            => 1,
            'flunnieline'     => 'asdasassaas',
        );
    }

    static protected function makeSampleDataObject($data = null)
    {
        return new SampleClassMethodDataObject($data);
    }

    static public function testCallable()
    {
        // callable method
    }

    public static function setUpBeforeClass()
    {
        $data = static::makeTestDataArray();
        static::$dataObject = static::makeSampleDataObject($data);
    }

    public function testSetValidInteger()
    {
        static::$dataObject->testInteger = 13;
        $this->assertEquals(13, static::$dataObject->testInteger);
    }

    public function testSetValidString()
    {
        static::$dataObject->testString = 'im_a_string';
        $this->assertEquals('im_a_string', static::$dataObject->testString);
    }

    public function testSetValidArray()
    {
        static::$dataObject->testArray = array('This is an array');
        $this->assertInternalType('array', static::$dataObject->testArray);
        $this->assertArrayHasKey(0, static::$dataObject->testArray);
        $this->assertEquals('This is an array', static::$dataObject->testArray[0]);
    }

    public function testSetValidObject()
    {
        static::$dataObject->testObject = static::makeSampleDataObject();
        $this->assertInstanceOf('\DataObject\SampleDataObject', static::$dataObject->testObject);
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
        $this->assertInstanceOf('\DataObject\SampleDataObject', static::$dataObject->testMixed);
    }

    public function testSerialize()
    {
        $serialize = static::$dataObject->serialize();
        $this->assertNotEquals(false, @unserialize($serialize));
    }

    public function testUnserialize()
    {
        $serialize = static::$dataObject->serialize();
        $this->assertInstanceOf('\DataObject\SampleDataObject', static::$dataObject->unserialize($serialize));
    }

    public function testExport()
    {
        $this->assertInternalType('array', static::$dataObject->export());
    }

    public function testJSON()
    {
        $json = static::$dataObject->json();
        $this->assertNotEquals(false, json_decode($json));
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

    public function testQueryString()
    {
        $string = static::$dataObject->queryString();
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

        $do = self::$dataObject;

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
            'testDataObject',
            'testObject',
            'testNull',
            'testCallable',
            'testTypedArray1',
            'testTypedArray2',
            'testTypedArray3',
            'testTypedArray4',
        );

        $do = self::$dataObject;

        array_map(function ($key) use ($do) {
            $do->$key = null;
        }, $properties);

        $self = $this;

        array_map(function ($key) use ($do, $self) {
            $self->assertEquals(null, $do->$key);
        }, $properties);
    }

}

new IndexPage();
