<?php

namespace EntityMarshal\Entity;

use EntityMarshal\AbstractEntity;
use EntityMarshal\Accessor\ClassMethodInterface;
use EntityMarshal\ReflectionHelper;
use ReflectionProperty;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\Entity
 */
abstract class ClassMethodEntity extends AbstractEntity implements ClassMethodInterface
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
            ReflectionProperty::IS_PRIVATE |
            ReflectionProperty::IS_PROTECTED
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
    public function __call($method, $arguments)
    {
        return $this->call($method, $arguments);
    }

    /**
    * {@inheritdoc}
    */
    protected function unsetProperties($keys)
    {
        return;
    }
}

