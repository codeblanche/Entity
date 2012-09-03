<?php

namespace DataObject;

use ReflectionClass;
use ReflectionProperty;

/**
 * @author     Merten van Gerven
 * @package    DataObject
 */
abstract class ObjectPropertyDataObject extends DataObject implements ObjectPropertyAccessorInterface
{

    protected function getDefaultPropertyType()
    {
        return 'mixed';
    }

    protected function getCalledClassName()
    {
        return get_called_class();
    }

    protected function getPropertiesAndTypes()
    {
        $properties = array();

        $reflection  = new ReflectionClass($this->getCalledClassName());
        $publicVars = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($publicVars as $publicVar) { /* @var ReflectionProperty $publicVar */
            $doc       = $publicVar->getDocComment();
            $key       = $publicVar->getName();
            $is_static = $publicVar->isStatic();

            if ($is_static) {
                continue;
            }

            $type = preg_match('/@var\s+([^\s]+)/i', $doc, $matches) ? $matches[1] : null;

            $properties[$key] = $type;
        }

        return $properties;
    }

    protected function getDefaultValues()
    {
        return get_class_vars($this->getCalledClassName());
    }

    public function &__get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

}
