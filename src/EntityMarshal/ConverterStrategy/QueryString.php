<?php

namespace EntityMarshal\ConverterStrategy;

class QueryString implements ConverterStrategyInterface
{

    protected $ignoreKeys = array();

    /**
     * Configure the query string converter strategy
     *
     * @param array     $ignoreKeys   Optional list of keys to ignore.
     */
    public functino __construct($type = self::HASH_TYPE_SHA256, $prefix = '', $suffix = '', $ignoreKeys = array())
    {
        $this->ignoreKeys   = $ignoreKeys;
    }

    /**
     * @param array
     *
     * @return string
     */
    public function convert(array $data)
    {
        if (is_array($this->ignoreKeys) && !empty($this->ignoreKeys)) {
            foreach ($this->ignoreKeys as $key) {
                unset($data[$key]);
            }
        }

        return http_build_query($data);
    }

}