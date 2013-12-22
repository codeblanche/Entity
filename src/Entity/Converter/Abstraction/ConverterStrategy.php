<?php

namespace Entity\Converter\Abstraction;

use SplObjectStorage;

/**
 * @author      Merten van Gerven
 * @category    Entity
 * @package     Entity\ConverterStrategy
 * @abstract
 */
abstract class ConverterStrategy implements ConverterStrategyInterface
{
    /**
     * @var SplObjectStorage   List of object references to check for circular referencing.
     */
    protected $objectRegistry;

    /**
     * @param mixed $var
     *
     * @return $this
     */
    protected function registerObject(&$var)
    {
        if (!is_object($var)) {
            return $this;
        }

        if (!($this->objectRegistry instanceof SplObjectStorage)) {
            $this->objectRegistry = new SplObjectStorage();
        }

        $this->objectRegistry->attach($var);

        return $this;
    }

    /**
     * @param mixed $var
     *
     * @return $this
     */
    protected function deregisterObject(&$var)
    {
        if (!($this->objectRegistry instanceof SplObjectStorage) || !is_object($var)) {
            return $this;
        }

        $this->objectRegistry->detach($var);

        return $this;
    }

    /**
     * @param mixed $var
     *
     * @return boolean
     */
    protected function isCircularReference(&$var)
    {
        if (!($this->objectRegistry instanceof SplObjectStorage) || !is_object($var)) {
            return false;
        }

        return $this->objectRegistry->contains($var);
    }
}

