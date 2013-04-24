<?php

namespace EntityMarshal\Convert\Strategy;

interface StrategyInterface
{
    /**
     * @param  \EntityMarshal\EntityInterface  $entity Entity instance
     *
     * @return string
     */
    public function convert(\EntityMarshal\EntityInterface $entity);
}

