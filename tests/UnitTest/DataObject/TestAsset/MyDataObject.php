<?php

namespace UnitTest\DataObject\TestAsset;

use \DataObject\DataObject;

class MyDataObject extends DataObject
{
    /** @var integer */
    public $integer;

    /** @var string */
    public $string;

    /** @var array */
    public $array;

    /** @var UnitTest\DataObject\TestAsset\MyDataObject */
    public $object;

    /** @var mixed */
    public $mixed;
}
