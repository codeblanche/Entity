<?php

namespace EntityMarshal;

/**
 * Class ReflectionHelper
 *
 * @author Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 */
class ReflectionHelper
{
    /**
     * Retrieve list of properties and types using reflection.
     *
     * @param integer $filter
     *
     * @return array
     */
    static public function ReflectProperties($className, $filter = null)
    {
        $properties  = array();
        $reflection  = new ReflectionClass($className);
        $publicVars  = $reflection->getProperties($filter);

        foreach ($publicVars as $publicVar) {
            /* @var ReflectionProperty $publicVar */
            $doc       = $publicVar->getDocComment();
            $key       = $publicVar->getName();
            $is_static = $publicVar->isStatic();

            if ($is_static) {
                continue;
            }

            $matches          = array();
            $properties[$key] = preg_match('/@var\s+([^\s]+)/i', $doc, $matches)
                ? $matches[1]
                : null;
        }

        return $properties;
    }
}
