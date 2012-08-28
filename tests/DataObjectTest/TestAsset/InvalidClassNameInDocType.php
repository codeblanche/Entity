<?php

namespace DataObjectTest\TestAsset;

use DataObject\DataObject;

class InvalidClassNameInDocType extends DataObject
{
    /** @var ThisClassDoesNotExistsReally */
    public $testObject;
}

