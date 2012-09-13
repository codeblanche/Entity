<?php

namespace EntityMarshal\ConverterStrategy;

use EntityMarshal\EntityInterface;

interface ConverterStrategyInterface
{

    /**
     * @param array
     */
    public function convert(array $data);

}
