<?php

namespace DataObjectTest\TestAsset;

use DataObject\ObjectPropertyDataObject;

class InvalidClassNameInDocType extends ObjectPropertyDataObject
{
    /** @var ThisClassDoesNotExistsReally */
    public $testObject;
}

