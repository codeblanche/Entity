<?php

namespace DataObjectTest\TestAsset;

use DataObject\DataObject;

class MyDataObject extends DataObject
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






