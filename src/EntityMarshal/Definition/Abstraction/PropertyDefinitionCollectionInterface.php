<?php

namespace EntityMarshal\Definition\Abstraction;

interface PropertyDefinitionCollectionInterface
{
    /**
     * Check whether collection contains a specified key
     *
     * @param   string $name
     *
     * @return  boolean
     */
    public function has($name);

    /**
     * Retrieve the property definition by name.
     *
     * @param   string $name
     *
     * @return  PropertyDefnitionInterface
     */
    public function get($name);

    /**
     * Return a list of keys for the collection
     *
     * @return  array
     */
    public function keys();

    /**
     * Add a list of properties and types
     *
     * @param   array $list   key=>type pair list of properties and types.
     *
     * @return  PropertyDefinitionCollectionInterface
     * @throws  InvalidArgumentException
     */
    public function import($list);

    /**
     * Add a single property and type
     *
     * @param string $name
     * @param string $type
     *
     * @return PropertyDefinitionCollectionInterface
     */
    public function add($name, $type);

    /**
     * Export a list of properties and types
     *
     * @return  array
     */
    public function export();
}
