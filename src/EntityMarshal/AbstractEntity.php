<?php

namespace EntityMarshal;

use stdClass;
use Traversable;

/**
 * This class is intended to be used as a base for pure data object classes
 * that contain typed (using phpdoc) public properties. Control over these
 * properties is deferred to EntityMarshal in order to validate inputs and auto-
 * matically cast values to the correct types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 * @dependency  Cloneable
 */
abstract class AbstractEntity implements EntityInterface
{

    /**
     * Values of public properties declared within EntityMarshal extendor.
     *
     * @var array
     */
    private $definitionValues = array();

    private $iteratorPosition = 0;

    private static $exceptions = array(
        5  => "Attempt to get type for property '%s' of class '%s' failed. Property does not exist.",
        6  => "Attempt to access property '%s' of class '%s' failed. Property does not exist.",
        7  => "Attempt to set property '%s' of class '%s' failed. Property does not exist.",
        8  => "Attempt to set property '%s' of class '%s' failed. Property type '%s' expected while type '%s' was given for value '%s'",
        9  => "Attempt to unset property '%s' of class '%s' failed. Property does not exist.",
        11 => "Could not unserialize %s in %s",
        12 => "Attempt to set property '%s' of class '%s' failed. Circular reference detected.",
    );

    /**
     * Default constructor.
     *
     * @param Traversable $data array of key/value pairs.
     */
    final public function __construct($data = null)
    {
        $this->iteratorPosition = 0;

        if (!is_null($data)) {
            $this->fromArray($data);
        }
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

                if ($type === 'object' && $val instanceof EntityMarshal) {
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
     * Return json encoded or json-ready structural representation of object.
     *
     * @param boolean $encoded
     */
    final public function json($encode = true)
    {
        $result = $this->jsonArray($this->definitionValues);

        if ($encode) {
            return json_encode($result);
        }

        return $result;
    }

    /**
     * Process array to make a json-ready structural representation of object.
     *
     * @param array $array
     *
     * @return array
     */
    final protected function jsonArray(&$array)
    {
        $result = array();

        foreach ($array as $key => $val) {
            if (isset($this->$key) && !empty($this->$key)) {
                $val = $this->$key;
            }

            if ($val instanceof self) {
                $result[$key] = $val->json(false);
            } elseif (is_array($val) || is_object($val)) {
                $val = (array) $val;
                $result[$key] = $this->jsonArray($val);
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }

    /**
     * Return an array representation of class properties and values.
     *
     * @return array
     */
    public function toArray()
    {
        $result = array();

        foreach ($array as $key=>$val) {
            if (isset($this->$key)) {
                $val = $this->$key;
            }

            if ($val instanceof self) {
                $result[$key] = $val->toArray();
            } elseif (is_object($val)) {
                $result[$key] = get_object_vars($val);
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }

    /**
     * Import an array of values into the data object. Array keys should match
     * EntityMarshal properties.
     *
     * @param array $data
     */
    public function fromArray($data)
    {
        foreach ($data as $key=>$val) {
            $this->set($key, $val, true);
        }
    }

    /**
     * Import a serialized string (json|serialize php) of values into the data
     * object. Data keys should match EntityMarshal properties.
     *
     * @param string $dataString
     */
    public function fromString($dataString)
    {
        // looking for json
        $decoded = json_decode($data, true);
        if (!is_null($decoded)) {
            return $this->import($decoded);
        }

        // looking for serialized.
        $unserialized = unserialize($data);
        if ($unserialized !== false) {
            return $this->import($decoded);
        }
    }

    /**
     * Import a json string of values into the data
     * object. Data keys should match EntityMarshal properties.
     *
     * @param string $jsonString
     */
    public function fromJson($jsonString)
    {
        // looking for json
        $decoded = json_decode($jsonString, true);
        if (!is_null($decoded)) {
            return $this->import($decoded);
        }
    }

    /**
     * Import values into the data object from another data object.
     * Data keys should match EntityMarshal properties.
     *
     * @param EntityMarshal $dataObject
     */
    public function fromEntityMarshal($dataObject)
    {
        foreach ($this->definitionKeys as $key) {
            $val = $this->definitionDefaults[$key];
            if ($data instanceof EntityMarshal && isset($data->$key)) {
                $val = $data->$key;
            }
            $this->set($key, $val, $graceful);
        }
    }

    /**
     * Alias of toArray
     *
     * @return array
     */
    final public function export()
    {
        return $this->jsonArray($this->definitionValues);
    }

    /**
     * Import data.
     *
     * @param string|array|EntityMarshal $data
     */
    public function import($data)
    {
        if (empty($data)) {
            return;
        }

        // handle data as a string.
        if (is_string($data)) {

            $this->fromString($data);

        // handle data as an array.
        } elseif (is_array($data)) {

            $this->fromArray($data);

        // handle data as a instance/child of EntityMarshal.
        } elseif ($data instanceof EntityMarshal) {

            $this->fromEntityMarshal($data);

        }
    }

    /**
     * Method for magic getter and private use.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws Exception\RuntimeException
     */
    protected function &get($name)
    {
        if (!in_array($name, $this->definitionKeys)) {
            throw new Exception\RuntimeException(sprintf(
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
     * @throws Exception\RuntimeException
     */
    protected function set($name, $value, $graceful = false)
    {
        if ($value === $this) {
            throw new Exception\RuntimeException(sprintf(
                self::$exceptions[12],
                $name,
                $this->calledClass
            ), 12);
        }

        if (!in_array($name, $this->definitionKeys)) {
            if ($this instanceof PermitDynamicPropertiesInterface) {
                $type = !is_null($this->definitionDefaultGenericType)
                    ? "{$this->definitionDefaultGenericType}[]"
                    : $this->definitionDefaultType;
                $this->initializeProperty($name, $type, null);
            } else {
                if ($graceful) {
                    return;
                }
                throw new Exception\RuntimeException(sprintf(
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
    * @throws Exception\RuntimeException
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

            throw new Exception\RuntimeException(sprintf(
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
     * Magic isset.
     *
     * @param string $name The key where you looking for
     *
     * @return boolean Wheter the value exists or not
     */
    public function __isset($name)
    {
        if (!in_array($name, $this->definitionKeys)) {
            return false;
        }

        return true;
    }

    /**
     * Magic unset.
     *
     * @param string $name
     *
     * @throws Exception\RuntimeException
     */
    public function __unset($name)
    {
        if (in_array($name, $this->definitionKeys) === false) {
            throw new Exception\RuntimeException(sprintf(
                self::$exceptions[9],
                $name,
                $this->calledClass
            ), 9);
        }

        unset($this->definitionValues[$name]);
    }

    /**
     * Handle necessary cleanup before serializing instance of EntityMarshal.
     *
     * @return returns a serialized array of the object
     */
    public function serialize()
    {
        return serialize($this->definitionValues);
    }

    /**
     * Handle necessary initialization for unserializing instance of EntityMarshal.
     *
     * @param  serialized $serialized The serialized created by the EntityMarshal::serialize()
     * @return self
     *
     * @throws Exception\RuntimeException
     */
    public function unserialize($serialized)
    {
        $this->initialize();

        $unserialized = @unserialize($serialized); // I'll catch the error and handle it

        if ($unserialized === false) {
            throw new Exception\RuntimeException(sprintf(
                self::$exceptions[11],
                $serialized,
                __METHOD__
            ), 11);
        }

        $this->definitionValues = unserialize($serialized);

        return $this;
    }

    /**
     * Cast a value to the desired type.
     *
     * @param mixed  $value The value you went to cast
     * @param string $type  The type you want to cast to
     *
     * @return mixed
     *
     * @throws Exception\RuntimeException
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
                throw new Exception\RuntimeException(sprintf(
                    self::$exceptions[10],
                    $type
                ), 10);
        }

        return $value;
    }

    /*
     * Iterator implementation.
     */
    final public function current()
    {
        $pos = $this->iteratorPos;
        $name = $this->definitionKeys[$pos];

        return $this->$name;
    }

    final public function key()
    {
        $pos = $this->iteratorPos;
        $name = $this->definitionKeys[$pos];

        return $name;
    }

    final public function next()
    {
        ++$this->iteratorPos;
    }

    final public function rewind()
    {
        $this->iteratorPos = 0;
    }

    final public function valid()
    {
        $pos = $this->iteratorPos;

        if ($pos < count($this->definitionKeys)) {
            $name = $this->definitionKeys[$pos];

            return isset($this->$name);
        }

        return false;
    }

}
