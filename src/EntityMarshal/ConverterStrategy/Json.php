<?php

namespace EntityMarshal\ConverterStrategy;

use EntityMarshal\AbstractEntityMarshal;
use EntityMarshal\EntityMarshalInterface;

/**
* Convert and entity to a Json string
*
* @package EntityMarshal\ConverterStrategy
*
* @todo Populate stub
*/
class Json extends AbstractConverterStrategy
{

    /**
     * @var boolean
     */
    protected $pretty = true;

    /**
     * Configure the hash converter strategy
     *
     * @param string    $pretty
     */
    public function __construct($pretty = true)
    {
        $this->pretty = $pretty;
    }

    /**
     * @param array     $data   Data to dump
     * @param string    $type   Optional: Data type definition override
     *
     * @return string
     */
    public function convert(array $data, EntityMarshalInterface $type = null)
    {
        $this->objectReferences = array();

        $resultArray = $this->convertRecursive($data, $type);

        return json_encode($resultArray);
    }

}