<?php
namespace EntityMarshal\Marshal;

/**
 * Class Stub
 * 
 * @author Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 */
class Stub implements MarshalInterface
{
    /**
     * {@inheritdoc}
     */
    public function ratify($name, $type, $value, $defined)
    {
        // this is just a stub so we can pass the values right back again.

        return $value;
    }
}
