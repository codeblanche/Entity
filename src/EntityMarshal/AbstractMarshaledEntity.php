<?php

namespace EntityMarshal;

use EntityMarshal\Exception\RuntimeException;
use EntityMarshal\RuntimeCache\RuntimeCacheEnabledInterface;
use ReflectionClass;
use stdClass;
use Traversable;

/**
 * This class is intended to be used as a base for pure data object classes that contain typed (using phpdoc) public
 * properties. Control over these properties is deferred to EntityMarshal in order to validate inputs and auto-matically
 * cast values to the correct types.
 *
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal
 */
abstract class AbstractMarshaledEntity extends AbstractEntity implements
    MarshaledEntityInterface,
    RuntimeCacheEnabledInterface
{

    /**
     * @var array       Maps phpdoc types to native (is_*) and/or user defined (instancof) types for validation.
     */
    private $typeMap = array(
        'array'     => 'array',
        'bool'      => 'bool',
        'callable'  => 'callable',
        'double'    => 'double',
        'float'     => 'float',
        'int'       => 'int',
        'integer'   => 'integer',
        'long'      => 'long',
        'null'      => 'null',
        'numeric'   => 'numeric',
        'object'    => 'object',
        'real'      => 'real',
        'resource'  => 'resource',
        'scalar'    => 'scalar',
        'string'    => 'string',
        'boolean'   => 'bool',
        'int'       => 'numeric',
        'integer'   => 'numeric',
        'double'    => 'numeric',
        'float'     => 'numeric',
        // default
        '*'         => 'object',
    );

    /**
     * @var array       Maps phpdoc types to native types for casting.
     */
    private $castMap = array(
        'int'       => 'int',
        'integer'   => 'integer',
        'long'      => 'long',
        'bool'      => 'bool',
        'boolean'   => 'boolean',
        'float'     => 'float',
        'double'    => 'double',
        'real'      => 'real',
        'string'    => 'string',
        'unset'     => 'unset',
        'null'      => 'unset',
    );

    /**
     * @var array       Key/type pairs of defined properties.
     */
    private $types = array(
        // default
        '*' => 'mixed',
    );

    /**
     * @var array       Generic types of public array/list properties declared within EntityMarshal extendor.
     */
    private $generics = array(
        // default
        '*' => null,
    );

    /**
     * @var boolean     Suppresses exceptions while setting non-existent properties.
     */
    private $graceful = false;

    /**
     * Initialize the definition arrays.
     *
     * @throws RuntimeException
     */
    private function initialize()
    {
        parent::initialize();

        $class          = $this->calledClassName();
        $cache          = $this->getRuntimeCache();
        $definitions    = $cache->get($class);

        if (!is_null($definitions)) {
            $this->types     = $definitions['types'];
            $this->generics  = $definitions['generics'];

            return;
        }

        $defaultType = $this->defaultPropertyType();
        $defaults    = $this->defaultValues();
        $properties  = $this->propertiesAndTypes();

        $this->initializeProperty('*', $defaultType);

        foreach ($properties as $name => $type) {
            $value = isset($defaults[$name])
                ? $defaults[$name]
                : null;

            $this->initializeProperty($name, $type);
            $this->set($name, $value);
        }

        $cache->set($class, array(
            'types'     => $this->types,
            'generics'  => $this->generics,
        ));
    }

    private function initializeProperty($name, $type)
    {
        if (empty($type)) {
            $type    = $this->types['*'];
            $generic = $this->generics['*'];
        } else {
            $generic = $this->extractGeneric($type);
        }

        if (strpos($type, '|')) {
            throw new RuntimeException(sprintf(
                "'%s' indicates a 'mixed' type in phpdoc for property '%s' of class '%s'. Please use 'mixed' instead.",
                $type,
                $name,
                $this->calledClassName()
            ));
        }

        if (!is_null($generic)) {
            if (!$this->isValidType($generic)) {
                throw new RuntimeException(sprintf(
                    "'%s' is not a valid native or object/class type in phpdoc for property '%s' of class '%s'",
                    $generic,
                    $name,
                    $this->calledClassName()
                ));
            }

            $this->generics[$name] = $generic;

            $type = 'array';
        }

        if (!$this->isValidType($type)) {
            throw new RuntimeException(sprintf(
                "'%s' is not a valid native or object/class type in phpdoc for property '%s' of class '%s'",
                $type,
                $name,
                $this->calledClassName()
            ));
        }

        $this->types[$name] = $type;
    }

    /**
     * Retrieve list of properties and types using reflection.
     *
     * @param   integer     $filter
     *
     * @return  array
     */
    protected function reflectProperties($filter = null)
    {
        $properties  = array();
        $reflection  = new ReflectionClass($this->getCalledClassName());
        $publicVars  = $reflection->getProperties($filter);

        foreach ($publicVars as $publicVar) { /* @var ReflectionProperty $publicVar */
            $doc       = $publicVar->getDocComment();
            $key       = $publicVar->getName();
            $is_static = $publicVar->isStatic();

            if ($is_static) {
                continue;
            }

            $properties[$key] = preg_match('/@var\s+([^\s]+)/i', $doc, $matches)
                ? $matches[1]
                : null;
        }

        return $properties;
    }

    /**
     * Check if the specified type is valid.
     *
     * @param   string      $type
     *
     * @return  boolean
     */
    private function isValidType($type)
    {
        if (
            !isset($this->typeMap[$type]) &&
            $type !== 'mixed' &&
            !class_exists($type)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Extract the generic subtype from the specified type if there is one.
     *
     * @param string $type
     *
     * @return string|null
     */
    protected function extractGeneric($type)
    {
        if (empty($type)) {
            return null;
        }

        $generic = null;

        if (substr($type, -2) === '[]') {
            $generic = substr($type, 0, -2);
        } elseif (
            strtolower(substr($type, 0, 6)) === 'array<' &&
            substr($type, -1) === '>'
        ) {
            $generic = preg_replace('/^array<([^>]+)>$/i', '$1', $type);
        }

        return $generic;
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if (!isset($this->types[$name])) {
            if ($this instanceof DynamicPropertyInterface) {
                $generic = $this->getGeneric('*');
                $type    = !is_null($generic)
                    ? "{$generic}[]"
                    : $this->getType('*');

                $this->initializeProperty($name, $type);
            } else {
                if ($this->graceful) {
                    return $this;
                }

                throw new RuntimeException(sprintf(
                    "Attempt to set property '%s' of class '%s' failed. Property does not exist.",
                    $name,
                    $this->calledClassName()
                ));
            }
        }

        if (!is_null($value)) {
            $type   = $this->getType($name);
            $generic = $this->getGeneric($name);

            $value = $this->prepareValue(
                $value,
                $type,
                $generic,
                $name
            );
        }

        return parent::set($name, $value);
    }

    /**
     * Get the property type for the given property name
     *
     * @param   string      $name
     *
     * @return  string
     */
    private function getType($name)
    {
        if (!isset($this->types[$name])) {
            $name = '*';
        }

        return $this->types[$name];
    }

    /**
     * Retrieve the generic type for the given property name
     *
     * @param   string      $name
     *
     * @return  string
     */
    private function getGeneric($name)
    {
        if (!isset($this->generics[$name])) {
            $name = '*';
        }

        return $this->generics[$name];
    }

    /**
    * Prepare a value for storage according to required types.
    *
    * @param mixed $value
    * @param string $type
    * @param string $generic
    * @param string $name
    *
    * @return mixed
    *
    * @throws RuntimeException
    */
    protected function prepareValue($value, $type, $generic = null, $name = '')
    {
        $definedType = $type;

        $castType = isset($this->castMap[$type])
            ? $this->castMap[$type]
            : null;

        if (!is_null($castType) && is_scalar($value)) {
            $casted = $this->cast($value, $castType);

            if (empty($value)) {
                $value = null;
            } elseif ($value == $casted) {
                $value = $casted;
            }

            unset($casted);
        }

        if (!is_null($generic) && (is_array($value) || $value instanceof Traversable)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->prepareValue(
                    $val,
                    $generic,
                    null,
                    "{$name}[{$key}]"
                );
            }
        }

        $mappedType = isset($this->typeMap[$type])
            ? $this->typeMap[$type]
            : $this->typeMap['*'];

        if (
            $mappedType === 'object' &&
            !is_object($value) && (
                is_array($value) ||
                $value instanceof Traversable
        )) {
            $value = $this->castToObject($value, $definedType);
        }

        if (!$this->graceful && $type !== 'mixed' && !is_null($value) && (
            !call_user_func("is_$mappedType", $value) || (
                $mappedType === 'object' &&
                $type !== 'object' &&
                !($value instanceof $type)
        ))) {
            $valueType = gettype($value);

            throw new RuntimeException(sprintf(
                "Attempt to set property '%s' of class '%s' failed. ".
                "Property type '%s' expected while type '%s' was given for value '%s'",
                $name,
                $this->calledClassName(),
                $type,
                $valueType,
                var_export($value, true)
            ));
        }

        return $value;
    }

    /**
     * Convert a value to the specified object type.
     *
     * @param   mixed   $value
     * @param   mixed   $type
     *
     * @return  mixed
     */
    protected function castToObject($value, $type)
    {
        if(!class_exists($type) && $type !== 'object') {
            return $value;
        }

        if (
            class_exists($type) &&
            is_subclass_of($type, '\EntityMarshal\AbstractEntity')
        ) {
            $value = new $type($value);
        } else {
            $obj = $type === 'object'
                ? new stdClass()
                : new $type();

            foreach($value as $key=>$val) {
                $obj->$key = $val;
            }

            $value = $obj;
        }

        return $value;
    }


    /**
     * Cast a value to the desired type.
     *
     * @param   mixed       $value  The value you went to cast
     * @param   string      $type   The type you want to cast to
     *
     * @return  mixed
     * @throws  RuntimeException
     */
    private function cast($value, $type)
    {
        switch ($type) {
            case 'int':
            case 'integer':
            case 'long':
                if (is_numeric($value)) {
                    $value = (integer) $value;
                }
                break;
            case 'bool':
            case 'boolean':
                $value = (boolean) $value;
                break;
            case 'float':
            case 'double':
            case 'real':
                $value = (float) $value;
                break;
            case 'string':
                $value = (string) $value;
                break;
            case 'array':
                $value = (array) $value;
                break;
            case 'object':
                $value = (object) $value;
                break;
            case 'unset':
                $value = (unset) $value;
                break;
            default:
                throw new RuntimeException(sprintf(
                    "Attempt to cast value to invalid type '%s'",
                    $type
                ));
                break;
        }

        return $value;
    }

}
