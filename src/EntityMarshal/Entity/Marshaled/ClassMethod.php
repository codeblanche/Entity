<?php

namespace EntityMarshal\Entity\Marshaled;

use EntityMarshal\AbstractMarshaledEntity;
use EntityMarshal\Accessor\ClassMethodInterface;
use ReflectionProperty;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
abstract class ClassMethod extends AbstractMarshaledEntity implements ClassMethodInterface
{
    /**
    * {@inheritdoc}
    */
    protected function defaultPropertyType()
    {
        return 'mixed';
    }

    /**
    * {@inheritdoc}
    */
    protected function calledClassName()
    {
        return get_called_class();
    }

    /**
    * {@inheritdoc}
    */
    protected function propertiesAndTypes()
    {
        return $this->reflectProperties(
            ReflectionProperty::IS_PRIVATE |
            ReflectionProperty::IS_PROTECTED
        );
    }

    /**
    * {@inheritdoc}
    */
    protected function defaultValues()
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
}

