<?php
/**
 * Created by JetBrains PhpStorm.
 * User: merten
 * Date: 4/26/13
 * Time: 8:38 AM
 * To change this template use File | Settings | File Templates.
 */

namespace EntityMarshal\Marshal;

use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;
use EntityMarshal\Marshal\Abstraction\MarshalInterface;
use EntityMarshal\RuntimeCache\Abstraction\RuntimeCacheInterface;
use EntityMarshal\RuntimeCache\RuntimeCache;

/**
 * Class Typed
 *
 * @author    Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 * @package   EntityMarshal\Marshal
 */
class Typed implements MarshalInterface
{

    /**
     * @var RuntimeCacheInterface
     */
    private static $defaultRuntimeCache;

    /**
     * @var RuntimeCacheInterface
     */
    protected $runtimeCache;

    /**
     * @var array       Maps phpdoc types to native types for casting.
     */
    private $scalarMap = array(
        'int'     => 'integer',
        'integer' => 'integer',
        'long'    => 'integer',
        'numeric' => 'string',
        'scalar'  => 'string',
        'bool'    => 'boolean',
        'boolean' => 'boolean',
        'float'   => 'float',
        'double'  => 'float',
        'real'    => 'float',
        'string'  => 'string',
        'char'    => 'string',
        'null'    => 'unset',
    );

    /**
     * @param RuntimeCacheInterface $runtimeCache
     */
    function __construct(RuntimeCacheInterface $runtimeCache = null)
    {
        if (!($runtimeCache instanceof RuntimeCacheInterface)) {
            $runtimeCache = $this->defaultRuntimeCache();
        }

        $this->runtimeCache = $runtimeCache;
    }

    /**
     * Retrieve an instance of the default runtime cache object
     *
     * @return RuntimeCacheInterface
     */
    protected function defaultRuntimeCache()
    {
        if (is_null(self::$defaultRuntimeCache)) {
            self::$defaultRuntimeCache = new RuntimeCache();
        }

        return self::$defaultRuntimeCache;
    }

    /**
     * @inheritdoc
     */
    public function ratify($value, PropertyDefinitionInterface $definition = null)
    {
        if (is_null($definition) || $definition->getType() === 'mixed' || $definition->getType() === '') {
            return $value;
        }

        if ($definition->isGeneric()) {
            return $this->iterate($value, $definition);
        }

        return $this->castValue($value, $definition->getType());
    }

    /**
     * Attempte to iterate the value and cast all child items to the require generic type.
     *
     * @param                             $value
     * @param PropertyDefinitionInterface $definition
     *
     * @return array
     */
    protected function iterate($value, PropertyDefinitionInterface $definition = null)
    {
        if (empty($value) || !is_array($value)) {
            return $value;
        }

        $type = $definition->getGenericType();

        foreach ($value as $key => $item) {
            if (is_null($item)) {
                continue;
            }

            $value[$key] = $this->castValue($item, $type);
        }

        return $value;
    }

    /**
     * Cast a value to the desired type non-destructively.
     *
     * @param mixed  $value
     * @param string $type
     *
     * @return mixed Cast value
     */
    protected function castValue($value, $type)
    {
        if (isset($this->scalarMap[$type])) {
            $cast = $this->castToScalar($value, $this->scalarMap[$type]);

            return $cast == $value ? $cast : $value;
        }

        if (is_null($value)) {
            return null;
        }

        if (!is_array($value) && $type === 'array') {
            return (array) $value;
        }

        if (!is_object($value) && $type === 'object') {
            return (object) $value;
        }

        return $this->castToClass($value, $this->resolveNamespace($type));
    }

    /**
     * Cast a value to the desired scalar type. Value remains unchanged if type is not scalar.
     *
     * @param mixed  $value The value you went to cast
     * @param string $type  The type you want to cast to
     *
     * @return mixed
     */
    protected function castToScalar($value, $type)
    {
        if ($type === 'integer') {
            return (integer) $value;
        }
        if ($type === 'boolean') {
            return (boolean) $value;
        }
        if ($type === 'float') {
            return (float) $value;
        }
        if ($type === 'string') {
            return (string) $value;
        }

        return $value;
    }

    protected function castToClass($value, $class)
    {
        if (!is_object($value) && !is_array($value)) {
            return $value;
        }

        if (!class_exists($class) || $value instanceof $class) {
            return $value;
        }

        if (!$this->runtimeCache->has($class)) {
            $this->runtimeCache->set($class, new $class());
        }

        $object = clone $this->runtimeCache->get($class);

        if (is_subclass_of($class, 'EntityMarshal\Abstraction\EntityInterface')) {
            $object->fromArray(is_array($value) || $value instanceof \Traversable ? $value : (array) $value);
        }
        else {
            foreach ($value as $key => $item) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    /**
     * Resolve class namespace.
     *
     * @param string $className
     *
     * @return string
     */
    protected function resolveNamespace($className)
    {
        // ToDo: investigate possibilities for resolving namespace dynamically.

        return $className;
    }
}
