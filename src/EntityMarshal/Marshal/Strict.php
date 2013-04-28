<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;

/**
 * Class Strict
 *
 * @author    Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 * @package   EntityMarshal\Marshal
 */
class Strict extends Named
{
    /**
     * @var array       Maps phpdoc types to native (is_*) and/or user defined (instancof) types for validation.
     */
    private $typeMap = array(
        'array'    => 'array',
        'bool'     => 'bool',
        'callable' => 'callable',
        'double'   => 'double',
        'float'    => 'float',
        'int'      => 'int',
        'integer'  => 'integer',
        'long'     => 'long',
        'null'     => 'null',
        'numeric'  => 'numeric',
        'object'   => 'object',
        'real'     => 'real',
        'resource' => 'resource',
        'scalar'   => 'scalar',
        'string'   => 'string',
        'boolean'  => 'bool',
        'int'      => 'numeric',
        'integer'  => 'numeric',
        'double'   => 'numeric',
        'float'    => 'numeric',
        // default
        '*'        => 'object',
    );

    /**
     * {@inheritdoc}
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null)
    {
        $value = parent::ratify($value, $definition);

        // TODO: validate type

        return $value;
    }
}
