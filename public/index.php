<?php

require '../init.php';

use DataObject\SampleDataObject;
use Timer\Timer;

class IndexPage
{
    public function __construct()
    {
        $t = Timer::Make();
        $dataObj1 = static::makeSampleDataObject();
        $t->stop()->dump();
        //$dataObj1->dump();

        $dataArray = static::makeTestDataArray();

        $t = Timer::Make();
        $dataObj2 = static::makeSampleDataObject($dataArray);
        $t->stop()->dump();
        //$dataObj2->dump();

        $serial = $dataObj2->serialize();

        $dataObj3 = static::makeSampleDataObject();
        $dataObj3->unserialize($serial);

        $dataObj1->dump();
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

    static protected function makeSampleDataObject($data)
    {
        return new SampleDataObject($data);
    }

    static public function testCallable()
    {
        // callable method
    }

}

new IndexPage();
