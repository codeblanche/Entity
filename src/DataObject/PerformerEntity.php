<?php

namespace DataObject;

use DataObject\DataObject;

/**
 * A sample DataObject using all known property types.
 *
 * @author      Merten van Gerven
 * @package     DataObject
 */
class PerformerEntity extends DataObject
{

    /**
    * @var integer
    */
    public $id;

    /**
    * @var ProfileEntity
    */
    public $profile;

    /**
    * @var DetailEntity
    */
    public $detail;

}
