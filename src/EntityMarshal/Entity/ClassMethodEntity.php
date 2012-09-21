<?php

namespace EntityMarshal\Entity;

use EntityMarshal\AbstractEntity;
use EntityMarshal\Accessor\ClassMethodInterface;

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
}

