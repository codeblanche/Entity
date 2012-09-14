<?php

namespace EntityMarshal\ConverterStrategy;

class QueryString extends AbstractConverterStrategy
{

    protected $ignoreKeys = array();

    /**
     * Configure the query string converter strategy
     *
     * @param array     $ignoreKeys   Optional list of keys to ignore.
     */
    public function __construct($ignoreKeys = array())
    {
        $this->ignoreKeys   = $ignoreKeys;
    }

    /**
     * @param array     $data   Data to dump
     * @param string    $type   Optional: Data type definition override
     *
     * @return string
     */
    public function convert(array $data, $type = 'array')
    {
        if (is_array($this->ignoreKeys) && !empty($this->ignoreKeys)) {
            foreach ($this->ignoreKeys as $key) {
                unset($data[$key]);
            }
        }

        return http_build_query($data);
    }

}