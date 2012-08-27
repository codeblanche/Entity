<?php

namespace UnitTest\DataObject\TestAsset;

use \DataObject\DataObject;

class InvalidClassNameInDocType extends DataObject
{
    /** @var ThisClassDoesNotExistsReally */
    public $object;
}
