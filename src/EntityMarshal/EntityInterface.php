<?php

namespace EntityMarshal;

use Iterator;
use Serializable;
use Traversable;

interface EntityInterface extends Iterator, Serializable
{

    public function set($name, $value);

    public function get($name);

    public function toArray($recursive);

    public function fromArray(Traversable $array);

    public function convert($strategy);

    public function output($strategy);

}