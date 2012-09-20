<?php

namespace EntityMarshal\Entity;

use EntityMarshal\AbstractEntity;
use EntityMarshal\Accessor\HybridInterface;

/**
 * @author      Merten van Gerven
 * @category    EntityMarshal
 * @package     EntityMarshal\Entity
 */
abstract class HybridEntity extends AbstractEntity implements HybridInterface
{
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

