<?php

namespace EntityMarshal\Abstraction;

use EntityMarshal\Converter\Abstraction\ConverterStrategyInterface;
use EntityMarshal\Converter\Dump;
use EntityMarshal\Converter\PhpArray;
use EntityMarshal\Definition\Abstraction\PropertyDefinitionCollectionInterface;
use EntityMarshal\Definition\Abstraction\PropertyDefinitionInterface;
use EntityMarshal\Definition\PropertyDefinitionCollection;
use EntityMarshal\Exception\RuntimeException;
use EntityMarshal\Marshal\Abstraction\MarshalInterface;
use EntityMarshal\Marshal\Exception\InvalidArgumentException;
use EntityMarshal\Marshal\Strict;
use EntityMarshal\RuntimeCache\Abstraction\RuntimeCacheInterface;
use EntityMarshal\RuntimeCache\RuntimeCache;
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
     * @var MarshalInterface Default marshal instance (shared with all entities)
     */
    private static $defaultMarshal;

    /**
     * @var RuntimeCacheInterface Default runtime cache instance (shared with all entities)
     */
    private static $defaultRuntimeCache;

    /**
     * @var PropertyDefinitionCollectionInterface Prototype of PropertyDefinitionCollectionInterface for cloning.
     */
    private static $prototypePropertyDefinitionCollection;

    /**
     * @var MarshalInterface
     */
    private $marshal;

    /**
     * @var RuntimeCacheInterface
     */
    private $runtimeCache;

    /**
     * @var array Values of public properties declared within EntityMarshal extendor.
     */
    private $properties = array();

    /**
     * @var PropertyDefinitionCollectionInterface
     */
    private $definitions;

    /**
     * @var integer
     */
    private $position = 0;

    /**
     * Default constructor.
     *
     * @param Traversable                           $data
     * @param MarshalInterface                      $marshal
     * @param PropertyDefinitionCollectionInterface $propertyDefinitionCollection
     * @param RuntimeCacheInterface                 $runtimeCache
     */
    public function __construct(
        $data = null,
        MarshalInterface $marshal = null,
        PropertyDefinitionCollectionInterface $propertyDefinitionCollection = null,
        RuntimeCacheInterface $runtimeCache = null
    ) {
        if (!($marshal instanceof MarshalInterface)) {
            $marshal = $this->defaultMarshal();
        }
        if (!($propertyDefinitionCollection instanceof PropertyDefinitionCollectionInterface)) {
            $propertyDefinitionCollection = $this->createPropertyDefinitionCollection();
        }
        if (!($runtimeCache instanceof RuntimeCacheInterface)) {
            $runtimeCache = $this->defaultRuntimeCache();
        }

        $this->position     = 0;
        $this->marshal      = $marshal;
        $this->runtimeCache = $runtimeCache;
        $this->definitions  = $propertyDefinitionCollection;

        $this->definitions->import($this->propertiesAndTypes());
        $this->unsetProperties($this->definitions->keys());
        $this->fromArray($this->defaultValues());

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
        if (is_null(self::$defaultMarshal)) {
            self::$defaultMarshal = new Strict();
        }

        return self::$defaultMarshal;
    }

    /**
     * Retrieve an instance of the default property definition object
     *
     * @return PropertyDefinitionCollectionInterface
     */
    protected function createPropertyDefinitionCollection()
    {
        if (is_null(self::$prototypePropertyDefinitionCollection)) {
            self::$prototypePropertyDefinitionCollection = new PropertyDefinitionCollection();
        }

        return clone self::$prototypePropertyDefinitionCollection;
    }

    /**
     * Retrieve an instance of the default runtime cache object
     *
     * @return \EntityMarshal\RuntimeCache\Abstraction\RuntimeCacheInterface
     */
    protected function defaultRuntimeCache()
    {
        if (is_null(self::$defaultRuntimeCache)) {
            self::$defaultRuntimeCache = new RuntimeCache();
        }

        return self::$defaultRuntimeCache;
    }

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

    /**
     * Unset the object properties defined by $keys
     *
     * @param array $keys
     */
    abstract protected function unsetProperties($keys);

    /**
     * {@inheritdoc}
     */
    public function fromArray($data)
    {
        if (!is_array($data) && !($data instanceof Traversable)) {
            throw new RuntimeException(sprintf(
                "Unable to import from array in class '%s' failed. Argument must be an array or Traversable",
                $this->calledClassName()
            ));
        }

        foreach ($data as $name => $value) {
            try {
                $this->set($name, $value);
            }
            catch (InvalidArgumentException $e) {
                continue;
            }
        }

        return $this;
    }

    /**
     * Get the default property values.
     *
     * @return array
     */
    abstract protected function defaultValues();

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
     * Standard __call method handler for subclass use.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    protected function call($method, &$arguments)
    {
        $matches = array();

        if (!preg_match('/^(?:(get|set|is)_?)(\w+)$/i', $method, $matches)) {
            return null;
        }

        $action = $matches[1];
        $name   = $matches[2];

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
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        $this->properties[$name] = $this->marshal->ratify(
            $value,
            $this->definitions->get($name)
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function typeof($name)
    {
        $definition = $this->definitions->get($name);

        if ($definition instanceof PropertyDefinitionInterface) {
            return $definition->getType();
        }

        return '';
    }

    /**
     * {@inheritdoc}
     *
     * @throws RuntimeException
     */
    public function &get($name)
    {
        if (!array_key_exists($name, $this->properties)) {
            throw new RuntimeException(sprintf(
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
    public function serialize()
    {
        return serialize($this->properties);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($recursive = true)
    {
        if (!$recursive) {
            return $this->properties;
        }

        return $this->convert(new PhpArray());
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->properties = unserialize($serialized);
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

        return !is_null($key) ? array_key_exists($key, $this->properties) : false;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(ConverterStrategyInterface $strategy)
    {
        return $strategy->convert($this);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->properties);
    }

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
    final public function dump($html = true)
    {
        echo $this->convert(new Dump($html));
    }
    // Implement Iterator

}
