<?php

namespace EntityMarshal;

use EntityMarshal\Exception\RuntimeException;
use EntityMarshal\RuntimeCache\RuntimeCacheEnabledInterface;
use ReflectionClass;
use stdClass;
use Traversable;

/**
 * This class is intended to be used as a base for pure data object classes
 * that contain typed (using phpdoc) public properties. Control over these
 * properties is deferred to EntityMarshal in order to validate inputs and auto-
 * matically cast values to the correct types.
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
     * Pipe seperated list of supported native $var = (*) $var cast types.
     */
    const CAST_MAP_ALLOWED = 'int|integer|long|bool|boolean|float|double|real|string|unset';

    /**
    * Supported Hash types
    */
    const HASH_TYPE_SHA256 = 'sha256';
    const HASH_TYPE_MD5 = 'md5';

    /**
     * Maps phpdoc types to native (is_*) and/or user defined (instancof) types
     * for validation.
     *
     * @var array
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
        '*'         => 'object', // default catchall
    );

    /**
     * Maps phpdoc types to native types for casting.
     *
     * @var array
     */
    private $castMap = array(
        'null' => 'unset',
    );

    /**
     * Keys of public properties declared within EntityMarshal extendor.
     *
     * @var array
     */
    private $definitionKeys = array();

    /**
     * Types of public properties declared within EntityMarshal extendor.
     *
     * @var array
     */
    private $definitionTypes = array();

    /**
     * Generic types of public array/list properties declared within EntityMarshal extendor.
     *
     * @var array
     */
    private $definitionGenerics = array();

    /**
     * Default property values declared within EntityMarshal extender.
     *
     * @var array
     */
    private $definitionDefaults = array();

    /**
     * Default type to be used for properties with no type.
     *
     * @var string
     */
    private $definitionDefaultType = 'mixed';

    /**
     * Default generics type to be used for array properties.
     * @var string
     */
    private $definitionDefaultGenericType = null;


    private static $exceptions = array(
        1  => "'%s' indicates a 'mixed' type in phpdoc for property '%s' of class '%s'. Please use 'mixed' instead.",
        2  => "'%s' is not a valid native or object/class type in phpdoc for property '%s' of class '%s'",
        3  => "'%s' is not a supported map type value while adding '%s' to type map.",
        4  => "'%s' is not a supported cast type value while adding '%s' to cast map.",
        5  => "Attempt to get type for property '%s' of class '%s' failed. Property does not exist.",
        6  => "Attempt to access property '%s' of class '%s' failed. Property does not exist.",
        7  => "Attempt to set property '%s' of class '%s' failed. Property does not exist.",
        8  => "Attempt to set property '%s' of class '%s' failed. Property type '%s' expected while type '%s' was given for value '%s'",
        9  => "Attempt to unset property '%s' of class '%s' failed. Property does not exist.",
        10 => "Attempt to cast value to invalid type '%s'",
        11 => "Could not unserialize %s in %s",
        11 => "Could not unserialize %s in %s",
        12 => "Attempt to set property '%s' of class '%s' failed. Circular reference detected.",
    );

    /**
     * Initialize the definition arrays.
     *
     * @throws RuntimeException
     */
    private function initialize()
    {
        parent::initialize();

        $this->initializeMaps();

        $class          = $this->calledClassName();
        $cache          = $this->getRuntimeCache();
        $definitions    = $cache->get($class);

        if (!is_null($definitions)) {
            $this->definitionDefaults           = $definitions['defaults'];
            $this->definitionKeys               = $definitions['keys'];
            $this->definitionTypes              = $definitions['types'];
            $this->definitionGenerics           = $definitions['generics'];
            $this->definitionValues             = $definitions['values'];
            $this->definitionDefaultType        = $definitions['default_type'];
            $this->definitionDefaultGenericType = $definitions['default_generic_type'];

            return;
        }

        $this->setDefaultAndDefaultGenericTypes();

        $defaultValues = $this->getDefaultValues();

        foreach ($this->getPropertiesAndTypes() as $key=>$type) {

            $defaultValue = isset($defaultValues[$key]) ? $defaultValues[$key] : null;

            $this->initializeProperty($key, $type, $defaultValue);

        }

        $cache->set($class, array(
            'defaults'             => $this->definitionDefaults,
            'keys'                 => $this->definitionKeys,
            'types'                => $this->definitionTypes,
            'generics'             => $this->definitionGenerics,
            'values'               => $this->definitionValues,
            'default_type'         => $this->definitionDefaultType,
            'default_generic_type' => $this->definitionDefaultGenericType,
        ));
    }

    private function initializeProperty($name, $type, $defaultValue)
    {
        if (empty($type)) {
            $type    = $this->definitionDefaultType;
            $subType = $this->definitionDefaultGenericType;
        } else {
            $subType = $this->extractGenericSubtype($type);
        }

        if (!is_null($subType)) {
            if (!$this->isValidType($subType)) {
                throw new RuntimeException(sprintf(
                    self::$exceptions[2],
                    $subType,
                    $name,
                    $this->calledClass
                ), 2);
            }

            $type = 'array';
            $this->definitionGenerics[$name] = $subType;
        }

        if (strpos($type, '|')) {
            throw new RuntimeException(sprintf(
                self::$exceptions[1],
                $type,
                $name,
                $this->calledClass
            ), 1);
        }

        if (!$this->isValidType($type)) {
            throw new RuntimeException(sprintf(
                self::$exceptions[2],
                $type,
                $name,
                $this->calledClass
            ), 2);
        }

        $this->definitionKeys[]          = $name;
        $this->definitionTypes[$name]    = $type;
        $this->definitionValues[$name]   = $defaultValue;
        $this->definitionDefaults[$name] = $defaultValue;
    }

    /**
     * Retrieve list of properties and types using reflection.
     *
     * @param   integer     $filter
     *
     * @return  array
     */
    protected function reflectPropertiesAndTypes($filter = null)
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

            $properties[$key] = preg_match('/@var\s+([^\s]+)/i', $doc, $matches) ? $matches[1] : null;
        }

        return $properties;
    }

    /**
     * Check if the specified type is valid.
     *
     * @param string $type
     *
     * @return boolean
     */
    private function isValidType($type)
    {
        $valid = true;

        if (
            !isset($this->typeMap[$type]) &&
            $type !== 'mixed' &&
            !class_exists($type)
        ) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * Set the default type and default generics subtype.
     */
    private function setDefaultAndDefaultGenericTypes()
    {
        $defaultType    = $this->getDefaultPropertyType();
        $defaultSubType = null;

        if (!empty($defaultType)) {
            $defaultSubType = $this->extractGenericSubtype($defaultType);

            if (!is_null($defaultSubType)) {
                $defaultType = 'array';
            }
        } else {
            $defaultType = 'mixed';
        }

        $this->definitionDefaultType        = $defaultType;
        $this->definitionDefaultGenericType = $defaultSubType;
    }

    /**
     * Extract the generic subtype from the specified type if there is one.
     *
     * @param string $type
     *
     * @return string|null
     */
    static public function extractGenericSubtype($type)
    {
        $subType = null;

        if (substr($type, -2) === '[]') {
            $subType = substr($type, 0, -2);
        } elseif (strtolower(substr($type, 0, 5)) === 'array' && substr($type, -1) === '>') {
            $subType = preg_replace('/^array<([^>]+)>$/i', '$1', $type);
        }

        return $subType;
    }

    /**
     * Initialize the map collections
     */
    private function initializeMaps()
    {
        if (isset(self::$runtimeCache['type_map']) && isset(self::$runtimeCache['cast_map'])) {
            $this->typeMap                      = self::$runtimeCache['type_map'];
            $this->castMap                      = self::$runtimeCache['cast_map'];

            return;
        }

        foreach (explode('|', self::CAST_MAP_ALLOWED) as $cast) {
            $this->castMap[$cast] = $cast;
        }

        self::$runtimeCache['type_map'] = $this->typeMap;
        self::$runtimeCache['cast_map'] = $this->castMap;
    }

    /**
     * Output dump of properties handled by EntityMarshal.
     *
     * @param boolean $html
     * @param boolean $return
     * @param string  $prefix
     */
    final public function dump($html = true, $return = false, $prefix = '')
    {
        $out = array();

        $len = count($this->definitionKeys);
        $out[] = "$prefix <span style='color:#00a;'>$this->calledClass</span> ($len) {";
        $prefix .= str_pad('', 4);

        $out = array_merge($out, $this->dumpArray($this->definitionValues, $prefix));

        $out[] = "$prefix }";
        $prefix = substr($prefix, 0, -4);

        if ($return) {
            return $out;
        } else {
            $result = PHP_EOL . implode(PHP_EOL, $out) . PHP_EOL;
            echo $html ? "<pre style='color:#555;'>$result</pre>" : strip_tags($result);
        }
    }

    /**
     * Process array for dump output.
     *
     * @param array  $array
     * @param string $prefix
     *
     * return array
     */
    final protected function dumpArray(&$array, $prefix = '', $generics_type = null)
    {
        $out = array();
        foreach ($array as $key => $val) {
            if (isset($this->$key) && !empty($this->$key)) {
                $val = $this->$key;
            }

            $type = gettype($val);

            $defined_type     = isset($this->definitionTypes[$key]) ? $this->definitionTypes[$key] : $type;
            $generics_subtype = null;

            if (isset($this->definitionGenerics[$key])) {
                $generics_subtype = $this->definitionGenerics[$key];
                $defined_type = "{$generics_subtype}[]";
            }

            if (!is_null($generics_type)) {
                $defined_type = $generics_type;
            }

            if (in_array($type, array('array', 'object'))) {
                $len = count($val);
                $sub = array();

                if ($type === 'object' && $val instanceof AbstractEntity) {
                    if ($val === $this) {
                        die('Possible endless recursion triggered.');
                    }
                    $sub    = $val->dump(true, true, $prefix);
                    $sub[0] = str_replace($prefix, "$prefix [<span style='color:#090;'>$key</span>]", $sub[0]);
                    $out    = array_merge($out, $sub);
                } else {
                    $out[]   = "$prefix [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) {";
                    $prefix .= str_pad('', 4);

                    $sub = $this->dumpArray($val, $prefix, $generics_subtype);
                    $out = array_merge($out, $sub);

                    $out[]  = "$prefix }";
                    $prefix = substr($prefix, 0, -4);
                }
            } else {
                $len = strlen($val);
                if ($type === 'string') {
                    $val = "\"$val\"";
                } elseif (is_bool($val)) {
                    $val = $val ? 'true' : 'false';
                } elseif (is_null($val)) {
                    $val = "<em style='color:#999;'>null</em>";
                }
                $out[] = "$prefix [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) => <span style='color:#a00;'>$val</span>";
            }
        }

        return $out;
    }

    /**
     * Method for magic getter and private use.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    protected function &get($name)
    {
        if (!in_array($name, $this->definitionKeys)) {
            throw new RuntimeException(sprintf(
                self::$exceptions[6],
                $name,
                $this->calledClass
            ), 6);
        }

        return $this->definitionValues[$name];
    }

    /**
     * Method for magic setter and private use.
     *
     * @param string  $name
     * @param mixed   $value
     * @param boolean $graceful skip exceptions for non existant properties.
     *
     * @throws RuntimeException
     */
    protected function set($name, $value, $graceful = false)
    {
        if ($value === $this) {
            throw new RuntimeException(sprintf(
                self::$exceptions[12],
                $name,
                $this->calledClass
            ), 12);
        }

        if (!in_array($name, $this->definitionKeys)) {
            if ($this instanceof DynamicPropertyInterface) {
                $type = !is_null($this->definitionDefaultGenericType)
                    ? "{$this->definitionDefaultGenericType}[]"
                    : $this->definitionDefaultType;
                $this->initializeProperty($name, $type, null);
            } else {
                if ($graceful) {
                    return;
                }
                throw new RuntimeException(sprintf(
                    self::$exceptions[7],
                    $name,
                    $this->calledClass
                ), 7);
            }
        }

        if (!is_null($value)) {
            $expected_type     = $this->getDefinitionType($name);
            $generics_subtype  = $this->getDefinitionGenericType($name, false);

            $this->definitionValues[$name] = $this->prepareValue(
                $value,
                $expected_type,
                $generics_subtype,
                $graceful,
                $name
            );
        } else {
            $this->definitionValues[$name] = null;
        }

        return $this;
    }


    private function getDefinitionType($name)
    {
        $type = $this->definitionDefaultType;

        if (isset($this->definitionTypes[$name])) {
            $type = $this->definitionTypes[$name];
            $subType = $this->getDefinitionGenericType($name, false);
        } else {
            $subType = $this->getDefinitionGenericType(null);
        }

        if (!empty($subType)) {
            $type = 'array';
        }

        return $type;
    }


    private function getDefinitionGenericType($name, $enableDefault=true)
    {
        $generic = null;

        if (!empty($name) && isset($this->definitionGenerics[$name])) {
            $generic = $this->definitionGenerics[$name];
        } elseif ($enableDefault && !is_null($this->definitionDefaultGenericType)) {
            $generic = $this->definitionDefaultGenericType;
        }

        return $generic;
    }

    /**
    * Prepare a value for storage according to required types.
    *
    * @param mixed $value
    * @param string $expected_type
    * @param string $generics_subtype
    * @param boolean $graceful
    * @param string $name
    *
    * @return mixed
    *
    * @throws RuntimeException
    */
    protected function prepareValue($value, $expected_type, $generics_subtype = null, $graceful = false, $name = '')
    {
        $defined_type = $expected_type;

        if ($graceful) {
            $expected_type = 'mixed';
        }

        $mapped_type = isset($this->typeMap[$expected_type]) ?
            $this->typeMap[$expected_type] : $this->typeMap['*'];

        $cast_type = isset($this->castMap[$expected_type]) ?
            $this->castMap[$expected_type] : null;

        if (!is_null($cast_type) && is_scalar($value)) {
            $casted = self::CastVar($value, $cast_type);

            if (empty($value)) {
                $value = null;
            } elseif ($value == $casted) {
                $value = $casted;
            }

            unset($casted);
        }

        if (!is_null($generics_subtype) && (is_array($value) || $value instanceof Traversable)) {
            foreach ($value as $key=>$val) {
                $value[$key] = $this->prepareValue(
                    $val,
                    $generics_subtype,
                    null,
                    $graceful,
                    "{$name}[{$key}]"
                );
            }
        }

        if (
            $mapped_type === 'object' &&
            !is_object($value) && (
                is_array($value) ||
                $value instanceof Traversable
            )
        ) {
            $value = $this->convertArrayToObjectType($value, $defined_type);
        }

        if (
            $expected_type !== 'mixed' &&
            !is_null($value) && (
                !call_user_func("is_$mapped_type", $value) || (
                    $mapped_type    == 'object' &&
                    $expected_type !== 'object' &&
                    !($value instanceof $expected_type)
                )
            )
        ) {

            $value_type = gettype($value);

            throw new RuntimeException(sprintf(
                self::$exceptions[8],
                $name,
                $this->calledClass,
                $expected_type,
                $value_type,
                var_export($value, true)
            ), 8);
        }

        return $value;
    }

    /**
    * Convert a value to the specified object type.
    *
    * @param mixed $value
    * @param mixed $defined_type
    *
    * return mixed
    */
    protected function convertArrayToObjectType($value, $defined_type)
    {
        if(!class_exists($defined_type) && $defined_type !== 'object') {
            return $value;
        }

        if (class_exists($defined_type) && is_subclass_of($defined_type, __CLASS__)) {
            $value = new $defined_type($value);
        } else {
            $obj = $defined_type === 'object' ? new stdClass() : new $defined_type();
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
     * @param mixed  $value The value you went to cast
     * @param string $type  The type you want to cast to
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    final public static function CastVar($value, $type)
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
                    self::$exceptions[10],
                    $type
                ), 10);
        }

        return $value;
    }

}
