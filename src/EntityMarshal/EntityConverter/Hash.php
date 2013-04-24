<?php

namespace EntityMarshal\EntityConversion;

use EntityMarshal\EntityInterface;

class Hash extends AbstractConvert
{
    /**
     * Supported Hash types
     */
    const HASH_TYPE_SHA256  = 'sha256';
    const HASH_TYPE_MD5     = 'md5';

    /**
     * @var string
     */
    protected $type = self::HASH_TYPE_SHA256;

    /**
     * @var string
     */
    protected $prefix = '';

    /**
     * @var string
     */
    protected $suffix = '';

    /**
     * @var array
     */
    protected $ignoreKeys = array();

    /**
     * Configure the hash converter strategy
     *
     * @param string $type
     * @param string $prefix
     * @param string $suffix
     * @param array  $ignoreKeys Optional list of keys to ignore.
     */
    public function __construct(
        $type = self::HASH_TYPE_SHA256,
        $prefix = '',
        $suffix = '',
        $ignoreKeys = array()
    ) {
        $this->type         = $type;
        $this->prefix       = $prefix;
        $this->suffix       = $suffix;
        $this->ignoreKeys   = $ignoreKeys;
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

        return hash($this->type, $this->prefix . implode('', array_values($data)) . $this->suffix);
    }
}

