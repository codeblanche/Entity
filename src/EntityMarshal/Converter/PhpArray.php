<?php

namespace EntityMarshal\Converter;

use EntityMarshal\Abstraction\EntityInterface;
use EntityMarshal\Converter\Abstraction\ConverterStrategy;
use Traversable;

/**
 * Convert and entity to a Dump string
 */
class PhpArray extends ConverterStrategy
{
    /**
     * @var boolean
     */
    protected $graceful = true;

    /**
     * Configure the array converter strategy
     *
     * @param   string $graceful   Return null for circular references when true.
     */
    public function __construct($graceful = false)
    {
        $this->graceful = $graceful;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(EntityInterface $entity)
    {
        return $this->recurse($entity);
    }

    /**
     * @param   object|array $data
     *
     * @return  array
     */
    protected function recurse($data)
    {
        if ($this->isCircularReference($data)) {
            if (!$this->graceful) {
                $className = __CLASS__;
                throw new Exception\RuntimeException("Cirular reference detected in '$className'.");
            }

            return null;
        }

        if (is_object($data) && !($data instanceof Traversable)) {
            $data = get_object_vars($data);
        }

        $result = array();

        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $result[$key] = $this->recurse($value);
            }
            else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

