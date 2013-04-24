<?php

namespace EntityMarshal\EntityConversion;

interface EntityConversionStrategyInterface
{
    /**
     * @param  \EntityMarshal\EntityInterface  $entity Entity instance
     *
     * @return string
     */
    public function convert(\EntityMarshal\EntityInterface $entity);
}

