<?php
namespace Cloneable;

use Cloneable\Exception\RuntimeException;
use Traversable;

/**
 * This class is intended to be used as a base for pure data object classes
 * that contain typed (using phpdoc) public properties. Control over these
 * properties is deferred to DataObject in order to validate inputs and auto-
 * matically cast values to the correct types.
 *
 * @author     Merten van Gerven
 * @package    Cloneable
 */
abstract class Cloneable
{
    /**
    * Magic clode method.
    */
    public function __clone()
    {
        static::cloneCollection($this);
    }

    /**
    * Deep clone an array|object collection of possible object references.
    *
    * @param array|object $collection
    */
    public static function cloneCollection(&$collection)
    {
        if (!is_array($collection) && !($collection instanceof Traversable)) {
            var_dump($collection);
            throw new RuntimeException("Expected argument to be an array or implement Traversable interface.");
        }

        foreach ($collection as $key=>$value) {
            if (is_array($value) || $value instanceof Traversable) {
                static::cloneCollection($value);
            }

            if (is_object($value)) {
                if (is_array($collection)) {
                    $collection[$key] = clone $value;
                } else {
                    $collection->$key = clone $value;
                }
            }
        }
    }

}
