<?php

namespace DataObjectTest\TestAsset;

use DataObject\ObjectPropertyDataObject;

class MyDataObject extends ObjectPropertyDataObject
{
    /** @var integer */
    public $testInteger;

    /** @var string */
    public $testString;

    /** @var array */
    public $testArray;

    /** @var DataObjectTest\TestAsset\MyDataObject */
    public $testObject;

    /** @var mixed */
    public $testMixed;
}






