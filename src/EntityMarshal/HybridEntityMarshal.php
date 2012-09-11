<?php

namespace EntityMarshal;

use ReflectionClass;
use ReflectionProperty;

/**
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
abstract class HybridEntityMarshal extends AbstractEntityMarshal implements HybridAccessorInterface
{
    /**
    * @var string Name of the property currenly being processed to prevent recursive loops.
    */
    private $propertySemaphore;

    /**
    * {@inheritdoc}
    */
    protected function getDefaultPropertyType()
    {
        return 'mixed';
    }

    /**
    * {@inheritdoc}
    */
    protected function getCalledClassName()
    {
        return get_called_class();
    }

    /**
    * {@inheritdoc}
    */
    protected function getPropertiesAndTypes()
    {
        $properties  = array();
        $reflection  = new ReflectionClass($this->getCalledClassName());
        $publicVars  = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($publicVars as $publicVar) { /* @var ReflectionProperty $publicVar */
            $doc       = $publicVar->getDocComment();
            $key       = $publicVar->getName();
            $is_static = $publicVar->isStatic();

            if ($is_static) {
                continue;
            }

            $properties[$key] = preg_match('/@var\s+([^\s]+)/i', $doc, $matches) ? $matches[1] : null;
        }

        return $properties;
    }

    /**
    * {@inheritdoc}
    */
    protected function getDefaultValues()
    {
        return get_class_vars($this->getCalledClassName());
    }

    /**
    * {@inheritdoc}
    */
    public function __call($method, $arguments)
    {
        if (!preg_match('/^(?:(get|set|is)_?)(\w+)$/i', $method, $matches)) {
            return;
        }

        $action  = $matches[1];
        $name    = $matches[2];

        var_dump("calling $name");

        switch ($action) {
            case 'is':
                $name   = "Is$name";
                // no break;
            case 'get':
                $name   = lcfirst($name);
                $return = $this->get($name);
            case 'set':
                $name   = lcfirst($name);
                $value  = $arguments[0];
                $return = $this->set($name, $value);
                break;
        }

        return $return;
    }

    /**
    * {@inheritdoc}
    */
    public function &__get($name)
    {
        return $this->get($name);
    }

    /**
    * {@inheritdoc}
    */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

}
