<?php

namespace EntityMarshal\Marshal;

/**
 * Class Strict
 *
 * @author Merten van Gerven
 * @copyright (c) 2013, Merten van Gerven
 */
class Strict extends Named
{
    /**
     * {@inheritdoc}
     */
    public function ratify($name, $type, $value, $defined)
    {
        $value = parent::ratify($name, $type, $value, $defined);

        // TODO: validate and/or convert value to the specified type

        return $value;
    }

}
