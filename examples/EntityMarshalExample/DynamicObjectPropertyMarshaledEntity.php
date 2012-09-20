<?php

namespace EntityMarshalExample;

use EntityMarshal\DynamicPropertyInterface;
use EntityMarshal\Entity\Marshaled\ObjectPropertyEntity;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicObjectPropertyMarshaledEntity extends ObjectPropertyEntity implements DynamicPropertyInterface
{
}

