<?php

namespace EntityMarshal\Converter\Abstraction;

use EntityMarshal\Abstraction\EntityInterface;

interface ConverterStrategyInterface
{
    /**
     * @param  \EntityMarshal\EntityInterface $entity Entity instance
     *
     * @return string
     */
    public function convert(EntityInterface $entity);
}

