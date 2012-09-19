<?php

use EntityMarshal\Entity\Marshaled\ClassMethod;

namespace EntitySample;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicClassMethodMarshaledEntity extends ClassMethod implements
    PermitDynamicPropertiesInterface
{
}

