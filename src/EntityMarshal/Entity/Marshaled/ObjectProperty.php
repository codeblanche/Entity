<?php

namespace EntityMarshal\Entity\Marshaled;

use EntityMarshal\AbstractMarshaledEntity;
use EntityMarshal\Accessor\ObjectPropertyInterface;
use ReflectionProperty;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
abstract class ObjectProperty extends AbstractMarshaledEntity implements ObjectPropertyInterface
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
        return $this->reflectProperties(
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

}
