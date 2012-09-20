<?php

namespace EntityMarshal\Convert;

use EntityMarshal\EntityInterface;

/**
* Convert and entity to a Json string
*
* @package EntityMarshal\ConverterStrategy
*/
class Json extends AbstractConvert
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

