<?php

use EntityMarshal\Entity\Marshaled\ObjectProperty;

namespace EntitySample;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicObjectPropertyMarshaledEntity extends ObjectProperty implements
    PermitDynamicPropertiesInterface
{
}

