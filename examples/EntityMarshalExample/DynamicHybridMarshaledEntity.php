<?php

namespace EntityMarshalExample;

use EntityMarshal\DynamicPropertyInterface;
use EntityMarshal\Entity\Marshaled\HybridEntity;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicHybridMarshaledEntity extends HybridEntity implements DynamicPropertyInterface
{
}

