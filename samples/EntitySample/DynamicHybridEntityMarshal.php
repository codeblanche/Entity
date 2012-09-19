<?php

namespace EntitySample;

use EntityMarshal\PermitDynamicPropertiesInterface;
use EntityMarshal\HybridEntityMarshal as AbstractHybridEntityMarshal;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class DynamicHybridEntityMarshal extends AbstractHybridEntityMarshal implements PermitDynamicPropertiesInterface
{
}

