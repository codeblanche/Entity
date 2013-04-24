<?php

namespace EntityMarshal\Converter\Abstraction;

interface ConverterStrategyInterface
{
    /**
     * @param  \EntityMarshal\EntityInterface $entity Entity instance
     *
     * @return string
     */
    public function convert(\EntityMarshal\EntityInterface $entity);
}

