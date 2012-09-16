<?php

namespace EntityMarshal\Entity\Marshaled;

use EntityMarshal\AbstractMarshaledEntity;
use EntityMarshal\Accessor\HybridInterface;
use ReflectionProperty;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
abstract class Hybrid extends AbstractMarshaledEntity implements HybridInterface
{

    /**
    * {@inheritdoc}
    */
    protected function getDefaultPropertyType()
    {
        return 'mixed';
    }

    /**
    * {@inheritdoc}
    */
    protected function getCalledClassName()
    {
        return get_called_class();
    }

    /**
    * {@inheritdoc}
    */
    protected function getPropertiesAndTypes()
    {
        return $this->reflectPropertiesAndTypes(
            ReflectionProperty::IS_PUBLIC
        );
    }

    /**
    * {@inheritdoc}
    */
    protected function getDefaultValues()
    {
        return get_class_vars($this->getCalledClassName());
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
