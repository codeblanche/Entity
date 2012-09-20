<?php

namespace EntityMarshal\Entity;

use EntityMarshal\AbstractEntity;
use EntityMarshal\Accessor\ObjectPropertyInterface;

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
}

