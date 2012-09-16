<?php

namespace EntityMarshal\Convert\Strategy;

interface StrategyInterface
{

    /**
     * @param   array   $data   Data to dump
     * @param   string  $type   Optional: Data type definition override
     * @return  string
     */
    public function convert(array $data, $type = null);

}
