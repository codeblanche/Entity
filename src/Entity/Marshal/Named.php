<?php

namespace Entity\Marshal;

use Entity\Definition\Abstraction\PropertyDefinitionInterface;
use Entity\Marshal\Abstraction\MarshalInterface;
use Entity\Marshal\Exception\InvalidArgumentException;

/**
 * Class Named
 *
 * @author    Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 * @package   Entity\Marshal
 */
class Named extends Typed
{
    /**
     * {@inheritdoc}
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null)
    {
        if (is_null($definition)) {
            throw new InvalidArgumentException("Property is not a named (defined) property");
        }

        return parent::ratify($value, $definition);
    }
}
