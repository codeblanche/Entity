<?php

namespace EntityMarshal\Abstraction;

use Countable;
use EntityMarshal\Converter\Abstraction\ConverterStrategyInterface;
use Iterator;
use Serializable;
use Traversable;

interface EntityInterface extends Iterator, Serializable, Countable
{

    /**
     * Get the the called class name.
     *
     * @return string
     */
    public function calledClassName();

    /**
     * Set a property
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return AbstractEntity
     */
    public function set($name, $value);

    /**
     * Get a property (by reference)
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function &get($name);

    /**
     * Return a key/value pair array
     *
     * @param  boolean $recursive
     *
     * @return array
     */
    public function toArray($recursive = true);

    /**
     * Import array of key/value pairs.
     *
     * @param  array|Traversable $data
     *
     * @return AbstractEntity
     */
    public function fromArray($data);

    /**
     * Convert the entity using the specified strategy.
     *
     * @param  ConverterStrategyInterface $strategy
     *
     * @return mixed
     */
    public function convert(ConverterStrategyInterface $strategy);

    /**
     * Shortcut to converting and printing the Dump ConverterStrategy.
     *
     * @param boolean $html
     */
    public function dump($html = true);

    /**
     * Get the type of the specified property.
     *
     * @param   string $name
     *
     * @return  string
     */
    public function typeof($name);
}

