<?php

namespace EntityMarshal;

use EntityMarshal\AbstractEntity;
use EntityMarshal\Accessor\ObjectPropertyInterface;
use EntityMarshal\ReflectionHelper;
use ReflectionProperty;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\Entity
 */
abstract class ObjectPropertyEntity extends AbstractEntity implements ObjectPropertyInterface
{
    /**
    * {@inheritdoc}
    */
    protected function defaultValues()
    {
        return get_class_vars($this->calledClassName());
    }

    /**
    * {@inheritdoc}
    */
    protected function propertiesAndTypes()
    {
        return ReflectionHelper::ReflectProperties(
            $this->calledClassName(),
            ReflectionProperty::IS_PUBLIC
        );
    }

    /**
    * {@inheritdoc}
    */
    public function calledClassName()
    {
        return get_called_class();
    }

    /**
     * {@inheritdoc}
     */
    public function &__get($name)
    {
        return $this->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
    * {@inheritdoc}
    */
    protected function unsetProperties($keys)
    {
        foreach ($keys as $key) {
            unset($this->$key);
        }
    }
}

