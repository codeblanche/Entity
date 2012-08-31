<?php

require '../init.php';

use DataObject\SampleDataObject;
use DataObject\DataObject;
use Timer\Timer;

class IndexPage
{
    const DO_CACHE = 'a:2:{s:11:"Timer\Timer";a:7:{s:8:"type_map";a:17:{s:7:"boolean";s:4:"bool";s:3:"int";s:3:"int";s:7:"integer";s:7:"integer";s:6:"double";s:6:"double";s:5:"float";s:5:"float";s:1:"*";s:6:"object";s:5:"array";s:5:"array";s:4:"bool";s:4:"bool";s:8:"callable";s:8:"callable";s:4:"long";s:4:"long";s:4:"null";s:4:"null";s:7:"numeric";s:7:"numeric";s:6:"object";s:6:"object";s:4:"real";s:4:"real";s:8:"resource";s:8:"resource";s:6:"scalar";s:6:"scalar";s:6:"string";s:6:"string";}s:8:"cast_map";a:11:{s:4:"null";s:5:"unset";s:3:"int";s:3:"int";s:7:"integer";s:7:"integer";s:4:"long";s:4:"long";s:4:"bool";s:4:"bool";s:7:"boolean";s:7:"boolean";s:5:"float";s:5:"float";s:6:"double";s:6:"double";s:4:"real";s:4:"real";s:6:"string";s:6:"string";s:5:"unset";s:5:"unset";}s:19:"definition_defaults";a:6:{s:6:"_start";N;s:4:"_end";N;s:5:"_diff";N;s:7:"seconds";i:0;s:12:"milliseconds";i:0;s:12:"microseconds";i:0;}s:15:"definition_keys";a:3:{i:0;s:7:"seconds";i:1;s:12:"milliseconds";i:2;s:12:"microseconds";}s:16:"definition_types";a:3:{s:7:"seconds";s:7:"integer";s:12:"milliseconds";s:7:"integer";s:12:"microseconds";s:7:"integer";}s:19:"definition_generics";a:0:{}s:17:"definition_values";a:3:{s:7:"seconds";i:0;s:12:"milliseconds";i:0;s:12:"microseconds";i:0;}}s:27:"DataObject\SampleDataObject";a:7:{s:8:"type_map";a:17:{s:7:"boolean";s:4:"bool";s:3:"int";s:3:"int";s:7:"integer";s:7:"integer";s:6:"double";s:6:"double";s:5:"float";s:5:"float";s:1:"*";s:6:"object";s:5:"array";s:5:"array";s:4:"bool";s:4:"bool";s:8:"callable";s:8:"callable";s:4:"long";s:4:"long";s:4:"null";s:4:"null";s:7:"numeric";s:7:"numeric";s:6:"object";s:6:"object";s:4:"real";s:4:"real";s:8:"resource";s:8:"resource";s:6:"scalar";s:6:"scalar";s:6:"string";s:6:"string";}s:8:"cast_map";a:11:{s:4:"null";s:5:"unset";s:3:"int";s:3:"int";s:7:"integer";s:7:"integer";s:4:"long";s:4:"long";s:4:"bool";s:4:"bool";s:7:"boolean";s:7:"boolean";s:5:"float";s:5:"float";s:6:"double";s:6:"double";s:4:"real";s:4:"real";s:6:"string";s:6:"string";s:5:"unset";s:5:"unset";}s:19:"definition_defaults";a:23:{s:8:"testBool";b:0;s:11:"testBoolean";b:1;s:11:"testInteger";i:12345;s:7:"testInt";i:67890;s:9:"testFloat";d:12.122999999999999;s:10:"testDouble";d:34.344999999999999;s:11:"testNumeric";i:34567;s:8:"testLong";i:23456;s:8:"testReal";d:56.567;s:12:"testResource";N;s:10:"testScalar";N;s:10:"testString";s:11:"test string";s:9:"testMixed";N;s:9:"testArray";a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";}s:12:"testStdClass";N;s:14:"testDataObject";N;s:10:"testObject";N;s:8:"testNull";N;s:12:"testCallable";N;s:15:"testTypedArray1";N;s:15:"testTypedArray2";N;s:15:"testTypedArray3";N;s:15:"testTypedArray4";N;}s:15:"definition_keys";a:23:{i:0;s:8:"testBool";i:1;s:11:"testBoolean";i:2;s:11:"testInteger";i:3;s:7:"testInt";i:4;s:9:"testFloat";i:5;s:10:"testDouble";i:6;s:11:"testNumeric";i:7;s:8:"testLong";i:8;s:8:"testReal";i:9;s:12:"testResource";i:10;s:10:"testScalar";i:11;s:10:"testString";i:12;s:9:"testMixed";i:13;s:9:"testArray";i:14;s:12:"testStdClass";i:15;s:14:"testDataObject";i:16;s:10:"testObject";i:17;s:8:"testNull";i:18;s:12:"testCallable";i:19;s:15:"testTypedArray1";i:20;s:15:"testTypedArray2";i:21;s:15:"testTypedArray3";i:22;s:15:"testTypedArray4";}s:16:"definition_types";a:23:{s:8:"testBool";s:4:"bool";s:11:"testBoolean";s:7:"boolean";s:11:"testInteger";s:7:"integer";s:7:"testInt";s:3:"int";s:9:"testFloat";s:5:"float";s:10:"testDouble";s:6:"double";s:11:"testNumeric";s:7:"numeric";s:8:"testLong";s:4:"long";s:8:"testReal";s:4:"real";s:12:"testResource";s:8:"resource";s:10:"testScalar";s:6:"scalar";s:10:"testString";s:6:"string";s:9:"testMixed";s:5:"mixed";s:9:"testArray";s:5:"array";s:12:"testStdClass";s:8:"stdClass";s:14:"testDataObject";s:27:"DataObject\SampleDataObject";s:10:"testObject";s:6:"object";s:8:"testNull";s:4:"null";s:12:"testCallable";s:8:"callable";s:15:"testTypedArray1";s:5:"array";s:15:"testTypedArray2";s:5:"array";s:15:"testTypedArray3";s:5:"array";s:15:"testTypedArray4";s:5:"array";}s:19:"definition_generics";a:4:{s:15:"testTypedArray1";s:27:"DataObject\SampleDataObject";s:15:"testTypedArray2";s:27:"DataObject\SampleDataObject";s:15:"testTypedArray3";s:5:"array";s:15:"testTypedArray4";s:7:"integer";}s:17:"definition_values";a:23:{s:8:"testBool";b:0;s:11:"testBoolean";b:1;s:11:"testInteger";i:12345;s:7:"testInt";i:67890;s:9:"testFloat";d:12.122999999999999;s:10:"testDouble";d:34.344999999999999;s:11:"testNumeric";i:34567;s:8:"testLong";i:23456;s:8:"testReal";d:56.567;s:12:"testResource";N;s:10:"testScalar";N;s:10:"testString";s:11:"test string";s:9:"testMixed";N;s:9:"testArray";a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";}s:12:"testStdClass";N;s:14:"testDataObject";N;s:10:"testObject";N;s:8:"testNull";N;s:12:"testCallable";N;s:15:"testTypedArray1";N;s:15:"testTypedArray2";N;s:15:"testTypedArray3";N;s:15:"testTypedArray4";N;}}}';

    /**
     * @var SampleDataObject
     */
    static private $do_instance;

    public function __construct()
    {
        $total = Timer::Make();

        DataObject::importCache(self::DO_CACHE);

        $t = Timer::Make();
        $dataObj1 = static::makeSampleDataObject();
        $t->stop()->dump();

        $dataArray = static::makeTestDataArray();

        $t = Timer::Make();
        $dataObj2 = static::makeSampleDataObject($dataArray);
        $t->stop()->dump();

        $serial = $dataObj2->serialize();

        $dataObj3 = static::makeSampleDataObject();
        $dataObj3->unserialize($serial);

        $dataObj1->dump();

        $total->stop();

        $total->dump();
    }

    /**
     * Some test data
     * @return array
     */
    static protected function makeTestDataArray()
    {
        $stdObj            = new \StdClass();
        $stdObj->testBool  = true;

        $dataObj           = new SampleDataObject();

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
        if(is_null(self::$do_instance)) {
            self::$do_instance = new SampleDataObject($data);
        }
        //*/
        return clone self::$do_instance;
        /*/
        return new SampleDataObject($data);
        //*/
    }

    static public function testCallable()
    {
        // callable method
    }

}

new IndexPage();
