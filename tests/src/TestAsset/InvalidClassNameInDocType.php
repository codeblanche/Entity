<?php

namespace EntityMarshalTest\TestAsset;

use EntityMarshal\ObjectPropertyEntityMarshal;

class InvalidClassNameInDocType extends ObjectPropertyEntityMarshal
{
    /** @var ThisClassDoesNotExistsReally */
    public $testObject;
}

