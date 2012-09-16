<?php

namespace EntityMarshal;

interface EntityMarshalInterface
{

    /**
     * Get the default property type to be used when no type is provided.
     * Default is 'mixed'
     *
     * @return string
     */
    public function defaultPropertyType();

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
     * @return array
     */
    public function propertiesAndTypes();

    /**
     * Get the default property values.
     *
     * @return array
     */
    public function defaultValues();
    
}
