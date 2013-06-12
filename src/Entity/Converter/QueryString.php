<?php

namespace Entity\Converter;

use Entity\Abstraction\EntityInterface;
use Entity\Converter\Abstraction\ConverterStrategy;

class QueryString extends ConverterStrategy
{
    protected $ignoreKeys = array();

    /**
     * Configure the query string converter strategy
     *
     * @param array $ignoreKeys Optional list of keys to ignore.
     */
    public function __construct($ignoreKeys = array())
    {
        $this->ignoreKeys = $ignoreKeys;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(EntityInterface $entity)
    {
        $data = $entity->toArray();

        if (is_array($this->ignoreKeys) && !empty($this->ignoreKeys)) {
            foreach ($this->ignoreKeys as $key) {
                unset($data[$key]);
            }
        }

        return http_build_query($data);
    }
}

