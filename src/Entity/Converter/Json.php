<?php

namespace Entity\Converter;

use Entity\Abstraction\EntityInterface;
use Entity\Converter\Abstraction\ConverterStrategy;

/**
 * Convert and entity to a Json string
 *
 * @package Entity\ConverterStrategy
 */
class Json extends ConverterStrategy
{
    /**
     * @var boolean
     */
    protected $pretty = true;

    /**
     * Configure the hash converter strategy
     *
     * @param string $pretty
     */
    public function __construct($pretty = true)
    {
        $this->pretty = $pretty;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(EntityInterface $entity)
    {
        $data = $entity->toArray();

        return json_encode($data);
    }
}

