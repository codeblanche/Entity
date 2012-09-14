<?php

namespace EntityMarshal;

use Iterator;
use Serializable;
use Traversable;
use Countable;
use EntityMarshal\ConverterStrategy\ConverterStrategyInterface;

interface EntityInterface extends Iterator, Serializable, Countable
{

    /**
     * Get the the called class name.
     *
     * @return  string
     */
    public function calledClassName();

    /**
     * Set a property
     *
     * @param   array           $data
     * @return  AbstractEntity
     */
    public function set($name, $value);

    /**
     * Get a property (by reference)
     *
     * @param   string          $name
     * @return  mixed
     */
    public function &get($name);

    /**
     * Return a key/value pair array
     *
     * @return  array
     */
    public function toArray();

    /**
     * Import array of key/value pairs.
     *
     * @param   array|Traversable     $data
     * @return  AbstractEntity
     */
    public function fromArray( $data);

    /**
     * Convert the entity using the specified strategy.
     *
     * @param   ConverterStrategyInterface  $strategy
     * @return  mixed
     */
    public function convert(ConverterStrategyInterface $strategy);

    /**
     * Convert and print the entity
     *
     * @param   ConverterStrategyInterface  $strategy
     */
    public function output(ConverterStrategyInterface $strategy);

    /**
     * Shortcut to converting and printing the Dump ConverterStrategy.
     *
     * @param   boolean     $html
     */
    public function dump($html = true);
}