<?php

namespace DataObjectTest\TestAsset;

use DataObject\DataObject;

class InvalidMixedPropertyIdentifier extends DataObject
{
    /** @var string|integer */
    public $testMixed;
}
