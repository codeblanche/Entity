<?php

namespace EntityMarshal\EntityConverterStrategy;

use EntityMarshal\EntityInterface;

interface EntityConverterStrategyInterface
{

    public function convert(array $data);

}
