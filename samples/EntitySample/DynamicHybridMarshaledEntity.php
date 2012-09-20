<?php

namespace EntitySample;

use EntityMarshal\DynamicPropertyInterface;
use EntityMarshal\Entity\Marshaled\Hybrid;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicHybridMarshaledEntity extends Hybrid implements DynamicPropertyInterface
{
}

