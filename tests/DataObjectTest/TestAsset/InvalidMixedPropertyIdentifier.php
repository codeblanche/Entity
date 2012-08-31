<?php

namespace DataObjectTest\TestAsset;

use DataObject\ObjectPropertyDataObject;

class InvalidMixedPropertyIdentifier extends ObjectPropertyDataObject
{
    /** @var string|integer */
    public $testMixed;
}
