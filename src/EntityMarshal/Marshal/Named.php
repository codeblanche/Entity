<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;
use EntityMarshal\Marshal\Abstraction\MarshalInterface;
use EntityMarshal\Marshal\Exception\InvalidArgumentException;

/**
 * Class Named
 *
 * @author    Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 * @package   EntityMarshal\Marshal
 */
class Named extends Typed
{
    /**
     * {@inheritdoc}
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null)
    {
        $value = parent::ratify($value, $definition);

        if (is_null($definition)) {
            throw new InvalidArgumentException("Property is not a named (defined) property");
        }

        return $value;
    }
}
