<?php

namespace UnitTest\DataObject\TestAsset;

use \DataObject\DataObject;

class InvalidMixedPropertyIdentifier extends DataObject
{
    /** @var string|integer */
    public $mixed;
}