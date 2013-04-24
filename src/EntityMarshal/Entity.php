<?php

namespace EntityMarshal;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\Entity
 */
class Entity extends AbstractEntity
{
    /**
    * {@inheritdoc}
    */
    protected function propertiesAndTypes($typeMask)
    {
        return $this->reflectProperties($typeMask);
    }

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
    public function calledClassName()
    {
        return get_called_class();
    }

    /**
    * {@inheritdoc}
    */
    public function __call($method, $arguments)
    {
        return $this->call($method, $arguments);
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
        return $this->set($name, $value);
    }
}

