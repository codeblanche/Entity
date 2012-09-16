<?php

namespace EntityMarshal\Convert;

use EntityMarshal\EntityMarshalInterface;

/**
* Convert and entity to a Json string
*
* @package EntityMarshal\ConverterStrategy
*
* @todo Populate stub
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
     * @param string    $pretty
     */
    public function __construct($pretty = true)
    {
        $this->pretty = $pretty;
    }


    /**
     * {@inheritdoc}
     */
    public function convert(array $data, $type = null)
    {
        $this->objectReferences = array();

        $resultArray = $this->convertRecursive($data, $type);

        return json_encode($resultArray);
    }

}