<?php

namespace DataObject;

use ReflectionClass;
use ReflectionMethod;

/**
 * @author     Merten van Gerven
 * @package    DataObject
 */
abstract class ClassMethodDataObject extends DataObject implements ClassMethodAccessorInterface
{

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
        $properties = array();

        $reflection  = new ReflectionClass($this->getCalledClassName());
        $methods     = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $methods     = array_filter($methods, function (ReflectionMethod $method) {
            $twosome   = substr($method->name, 0, 2);
            $threesome = substr($method->name, 0, 3);

            if ($twosome === 'is' || $threesome === 'set' || $threesome === 'get') {
                return true;
            }
        });

        var_dump($methods);

//        $publicVars  = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

//        foreach ($publicVars as $publicVar) { /* @var ReflectionProperty $publicVar */
//            $doc       = $publicVar->getDocComment();
//            $key       = $publicVar->getName();
//            $is_static = $publicVar->isStatic();

//            if ($is_static) {
//                continue;
//            }

//            $properties[$key] = preg_match('/@var\s+([^\s]+)/i', $doc, $matches) ? $matches[1] : null;
//        }


        return $properties;
    }

    /**
    * {@inheritdoc}
    */
    protected function getDefaultValues()
    {
        return array();
    }

    /**
    * {@inheritdoc}
    */
    public function __call($name, $arguments)
    {
        //;
    }

}
