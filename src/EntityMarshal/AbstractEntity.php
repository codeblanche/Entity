<?php

namespace EntityMarshal;

use EntityMarshal\Convert\Dump;
use EntityMarshal\Convert\Strategy\StrategyInterface;
use EntityMarshal\Definition\PropertyDefinition;
use EntityMarshal\Definition\PropertyDefinitionCollection;
use EntityMarshal\Definition\PropertyDefnitionInterface;
use EntityMarshal\EntityInterface;
use EntityMarshal\Marshal\MarshalInterface;
use EntityMarshal\Marshal\Strict;
use EntityMarshal\RuntimeCache\RuntimeCacheInterface;
use EntityMarshal\RuntimeCache\RuntimeCacheSingleton;
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
 * @abstract
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * @var MarshalInterface
     */
    private $marshal;

    /**
     * @var PropertyDefnitionInterface
     */
    private $propertyDefinitionPrototype;

    /**
     * @var RuntimeCacheInterface
     */
    private $runtimeCache;

    /**
     * @var array Values of public properties declared within EntityMarshal extendor.
     */
    private $properties = array();

    /**
     * @var PropertyDefinitionCollection
     */
    private $definitions;

    /**
     * Default constructor.
     *
     * @param Traversable       $data       array of key/value pairs.
     * @param MarshalInterface  $marshal    marshal to be used on this entity
     */
    final public function __construct($data = null, $marshal = null, $propertyDefinitionPrototype = null, $runtimeCache = null)
    {
        $this->position = 0;

        $this->marshal = $marshal instanceof MarshalInterface
            ? $marshal
            : $this->defaultMarshal();

        $this->propertyDefinitionPrototype = $propertyDefinitionPrototype instanceof PropertyDefnitionInterface
            ? $propertyDefinitionPrototype
            : $this->defaultPropertyDefinition();

        $this->runtimeCache = $runtimeCache instanceof RuntimeCacheInterface
            ? $runtimeCache
            : $this->defaultRuntimeCache();

        $this->initialize();

        if (!is_null($data)) {
            $this->fromArray($data);
        }
    }

    /**
     * Retrieve an instance of the default marshal
     *
     * @return MarshalInterface
     */
    protected function defaultMarshal()
    {
        return new Strict;
    }

    /**
     * Retrieve an instance of the default property definition object
     *
     * @return PropertyDefinition
     */
    protected function defaultPropertyDefinition()
    {
        return new PropertyDefinition;
    }

    /**
     * Retrieve an instance of the default runtime cache object
     *
     * @return RuntimeCacheInterface
     */
    protected function defaultRuntimeCache()
    {
        return RuntimeCacheSingleton::getInstance();
    }

    /**
     * {@inheritdoc}
     */
    final public function dump($html = true)
    {
        echo $this->convert(new Dump($html));
    }

    /**
     * Initialize the entity.
     */
    protected function initialize()
    {
        $this->definitions->import($this->propertiesAndTypes());

        $this->unsetProperties($this->definitions->keys());

        $this->fromArray($this->defaultValues());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($recursive = true)
    {
        if (!$recursive) {
            return $this->properties;
        }

        return $this->convert(new Convert\PhpArray());
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray($data)
    {
        if (!is_array($data) && !($data instanceof Traversable)) {
            throw new Exception\RuntimeException(sprintf(
                "Unable to import from array in class '%s' failed. Argument must be an array or Traversable",
                $this->calledClassName()
            ));
        }

        foreach ($data as $name => $value) {
            $this->set($name, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(StrategyInterface $strategy)
    {
        return $strategy->convert($this);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception\RuntimeException
     */
    public function &get($name)
    {
        if (!array_key_exists($name, $this->properties)) {
            throw new Exception\RuntimeException(sprintf(
                "Attempt to access property '%s' of class '%s' failed. Property does not exist.",
                $name,
                $this->calledClassName()
            ));
        }

        return $this->properties[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        $this->properties[$name] = $this->marshal->ratify(
            $name,
            $this->typeof($name),
            $value,
            $this->definitions->has($name)
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function typeof($name)
    {
        $definition = $this->definitions->get($name); /* @var $definition PropertyDefinitionInterface */

        return $definition ? $definition->getType() : $this->defaultPropertyType();
    }

    /**
     * Standard __call method handler for subclass use.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    protected function call($method, &$arguments)
    {
        $matches = array();

        if (!preg_match('/^(?:(get|set|is)_?)(\w+)$/i', $method, $matches)) {
            return;
        }

        $action  = $matches[1];
        $name    = $matches[2];

        if ($action === 'is') {
            $name   = "is$name";
            $action = 'get';
        }

        $propertyName = lcfirst($name);

        if ($action === 'set') {
            return $this->set($propertyName, $arguments[0]);
        }
        else {
            return $this->get($propertyName);
        }
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    /**
     * handle clone
     */
    public function __clone()
    {
        $this->position = 0;
    }

    /**
     * Get the default property type to be used when no type is provided.
     * Default is 'mixed'
     *
     * @return string
     */
    protected function defaultPropertyType() {
        return 'mixed';
    }

    /**
     * Get the default property values.
     *
     * @return array
     */
    abstract protected function defaultValues();

    /**
     * Unset the object properties defined by $keys
     *
     * @param array $keys
     */
    abstract protected function unsetProperties($keys);

    /**
     * Get the list of accessible properties and their associated types as an
     * associative array.
     * <code>
     * return array(
     *     'propertyName'  => 'propertyType'
     *     'propertyName2' => 'null'
     * );
     * </code>
     *
     * @return  array
     */
    abstract protected function propertiesAndTypes();

    // Implement Iterator

    /**
     * @var integer
     */
    private $position = 0;

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $keys = array_keys($this->properties);
        $key  = $keys[$this->position];

        return $this->properties[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $keys = array_keys($this->properties);

        return $keys[$this->position];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        $keys = array_keys($this->properties);
        $key  = null;

        if ($this->position < count($keys)) {
            $key = $keys[$this->position];
        }

        return !is_null($key)
            ? array_key_exists($key, $this->properties)
            : false ;
    }

    // Implement Serializable

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->properties);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->properties = unserialize($serialized);
    }

    // Implement Countable

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->properties);
    }
}

