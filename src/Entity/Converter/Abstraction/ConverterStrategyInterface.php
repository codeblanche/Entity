<?php

namespace Entity\Converter\Abstraction;

use Entity\Abstraction\EntityInterface;

interface ConverterStrategyInterface
{
    /**
     * @param  \Entity\EntityInterface $entity Entity instance
     *
     * @return string
     */
    public function convert(EntityInterface $entity);
}

