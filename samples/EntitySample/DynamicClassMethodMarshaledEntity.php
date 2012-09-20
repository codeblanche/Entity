<?php

namespace EntitySample;

use EntityMarshal\DynamicPropertyInterface;
use EntityMarshal\Entity\Marshaled\ClassMethodEntity;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicClassMethodMarshaledEntity extends ClassMethodEntity implements DynamicPropertyInterface
{
}

