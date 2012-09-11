<?php

namespace EntityMarshalTest\TestAsset;

use EntityMarshal\ObjectPropertyEntityMarshal;

class InvalidMixedPropertyIdentifier extends ObjectPropertyEntityMarshal
{
    /** @var string|integer */
    public $testMixed;
}
