<?php
spl_autoload_register(function($class) {
    $file = FILE_ROOT.DS.'Paynl'.DS.'DataObject'.DS.$class.'.php';
    if (is_file($file)) {
        include $file;
    }
});

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
    * @expectedException \Paynl\DataObject\DataObjectException
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
    * @expectedException \Paynl\DataObject\DataObjectException
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
    * @expectedException \Paynl\DataObject\DataObjectException
    */
    public function testSetInvalidArray()
    {
        self::$dataObject->array = 'im_a_string';
    }

    public function testSetValidObject()
    {
        self::$dataObject->object = new MyDataObject();
        $this->assertInstanceOf('MyDataObject', self::$dataObject->object);
    }

    /**
    * @expectedException \Paynl\DataObject\DataObjectException
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
        $this->assertInstanceOf('MyDataObject', self::$dataObject->mixed);
    }

    /**
    * @expectedException \Paynl\DataObject\DataObjectException
    */
    public function testInvalidClassNameInDoctype()
    {
        $object = new InvalidClassNameInDocType();
    }

    /**
    * @expectedException \Paynl\DataObject\DataObjectException
    */
    public function testInvalidMixedDefinationInDoctype()
    {
        $object = new InvalidMixedPropertyIdentifier();
    }
    
    /**
    * @expectedException \Paynl\DataObject\DataObjectException
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
        $this->assertInstanceOf('MyDataobject', self::$dataObject->unserialize($serialize));
    }
    
    public function testExport()
    {
        $this->assertInternalType('array', self::$dataObject->export());
    }
    
    public function testImport()
    {
        $this->markTestIncomplete();
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
    * @expectedException Paynl\DataObject\DataObjectException
    */
    public function testImportCacheInvalid()
    {
        $serialize = 'im not a serialized thing';
        self::$dataObject->ImportCache($serialize);
    }
    
    public function testQueryString()
    {
        $string = self::$dataObject->queryString();
        $data = array();
        parse_str($string, $data);
        
        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data);
    }
    
    public function testJSON() 
    {
        $json = self::$dataObject->json();       
        $this->assertNotEquals(false, json_decode($json));
    }
}
