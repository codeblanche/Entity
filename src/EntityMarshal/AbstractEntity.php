<?php

namespace EntityMarshal;

use EntityMarshal\Convert\Strategy\StrategyInterface;
use EntityMarshal\Convert\Dump;
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
     * Values of public properties declared within EntityMarshal extendor.
     *
     * @var array
     */
    private $properties = array();

    /**
     * Default constructor.
     *
     * @param Traversable $data array of key/value pairs.
     */
    final public function __construct($data = null)
    {
        $this->position = 0;

        $this->initialize();

        if (!is_null($data)) {
            $this->fromArray($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function dump($html = true)
    {
        $this->output(new Dump($html));
    }

    /**
     * Initialize the entity.
     */
    protected function initialize()
    {
        $vars = ForeignScope::getInstance()
            ->getObjectVars($this);

        $this->unsetProperties(array_keys($vars));
    }

    /**
     * Unset the object properties defined by $keys
     *
     * @param array $keys
     */
    protected function unsetProperties($keys)
    {
        if (!is_array($keys) || empty($keys)) {
            return;
        }

        foreach ($keys as $key) {
            unset($this->$key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($recursive = true)
    {
        if (!$recursive) {
            return $this->properties;
        }

        $result = array();

        foreach ($this->properties as $key => $value) {
            if ($value instanceof EntityInterface) {
                $result[$key] = $value->toArray($recursive);
            } elseif (is_object($value)) {
                $result[$key] = get_object_vars($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray($data)
    {
        if (!is_array($data) && !($data instanceof Traversable)) {
            $className = $this->calledClassName();
            throw new Exception\RuntimeException(
                "Unable to import from array in class '$className' failed. Argument must be an array or Traversable"
            );
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
        return $strategy->convert(
            $this->toArray(),
            $this->calledClassName()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function output(StrategyInterface $strategy)
    {
        echo $this->convert($strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception\RuntimeException
     */
    public function &get($name)
    {
        if (!isset($this->properties[$name])) {
            $className = $this->calledClassName();
            throw new Exception\RuntimeException(
                "Attempt to access property '$name' of class '$className' failed. Property does not exist."
            );
        }

        return $this->properties[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        $this->properties[$name] = $value;

        return $this;
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

        switch ($action) {
            case 'is':
                $name   = "Is$name";
                // no break
            case 'get':
                $name   = lcfirst($name);
                $return = $this->get($name);
                break;
            case 'set':
                $name   = lcfirst($name);
                $return = $this->set($name, $arguments[0]);
                break;
        }

        return $return;
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
        $keys   = array_keys($this->properties);
        $key    = $keys[$this->position];

        return $this->properties[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $keys   = array_keys($this->properties);

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
            ? isset($this->properties[$key])
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

