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

    protected function getPropertiesAndTypes($calledClass)
    {
        $properties = array();

        $reflection  = new ReflectionClass($calledClass);
        $publicVars = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($publicVars as $publicVar) { /* @var ReflectionProperty $public_var */
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

    public function &__get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

}
