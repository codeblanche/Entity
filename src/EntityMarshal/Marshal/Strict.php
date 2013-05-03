<?php

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;
use EntityMarshal\Marshal\Exception\LogicException;
use EntityMarshal\Marshal\Exception\RuntimeException;

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
        'boolean'  => 'bool',
        'callable' => 'callable',
        'double'   => 'float',
        'float'    => 'float',
        'int'      => 'int',
        'integer'  => 'int',
        'long'     => 'long',
        'null'     => 'null',
        'numeric'  => 'numeric',
        'object'   => 'object',
        'real'     => 'real',
        'resource' => 'resource',
        'scalar'   => 'scalar',
        'string'   => 'string',
    );

    /**
     * {@inheritdoc}
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null)
    {
        $value = parent::ratify($value, $definition);

        if (is_null($value)) {
            return $value;
        }

        $type = $definition->getType();
        $name = $definition->getName();

        $this->validateType($value, $type, $name);

        if ($definition->isGeneric()) {
            $type = $definition->getGenericType();

            $this->validateGenericType($value, $type, $name);
        }

        return $value;
    }

    /**
     * @param mixed  $value
     * @param string $type
     * @param string $name
     *
     * @throws Exception\RuntimeException
     * @throws Exception\LogicException
     */
    protected function validateType($value, $type, $name)
    {
        if (empty($type) || $type === 'mixed') {
            return;
        }

        if (isset($this->typeMap[$type])) {
            $test = 'is_' . $this->typeMap[$type];

            if (!call_user_func($test, $value)) {
                $givenType = gettype($value);

                throw new RuntimeException("Expected property '{$name}' to be a '{$type}'. '{$givenType}' given.");
            }

            return;
        }

        if (class_exists($type)) {
            if (!($value instanceof $type)) {
                $givenType = gettype($value);

                throw new RuntimeException("Expected property '{$name}' to be a '{$type}'. '{$givenType}' given.");
            }

            return;
        }

        throw new LogicException("Unrecognized type '{$type}' for property '{$name}'");
    }

    /**
     * @param mixed  $value
     * @param string $type
     * @param string $name
     */
    protected function validateGenericType($value, $type, $name)
    {
        if (empty($value)) {
            return;
        }

        foreach ($value as $key => $item) {
            $itemName = "{$name}[{$key}]";

            $this->validateType($item, $type, $itemName);
        }
    }
}
