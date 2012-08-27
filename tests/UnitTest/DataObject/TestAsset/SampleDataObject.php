<?php

namespace UnitTest\DataObject\TestAsset;

use \DataObject\DataObject;

/**
 * A sample DataObject using all known property types.
 *
 * @author      Merten van Gerven
 * @package     DataObject
 */
class SampleDataObject extends DataObject
{

    /**
     * @var bool
     */
    public $t_bool = false;

    /**
     * @var boolean Alias of bool
     */
    public $t_boolean = true;

    /**
     * @var integer Alias of int
     */
    public $t_integer = 12345;

    /**
     * @var int
     */
    public $t_int = 67890;

    /**
     * @var float
     */
    public $t_float = 12.123;

    /**
     * @var double Alias of float
     */
    public $t_double = 34.345;

    /**
     * @var numeric
     */
    public $t_numeric = 34567;

    /**
     * @var long Alias of int
     */
    public $t_long = 23456;

    /**
     * @var real Aliss of float
     */
    public $t_real = 56.567;

    /**
     * @var resource
     */
    public $t_resource;

    /**
     * @var scalar Basix data type including int, float, string, bool
     */
    public $t_scalar;

    /**
     * @var string
     */
    public $t_string = "test string";

    /**
     * @var mixed
     */
    public $t_mixed ;

    /**
     * @var array
     */
    public $t_array = array('1', '2', '3');

    /**
     * @var stdClass
     */
    public $t_stdclass;

    /**
     * @var DataObject
     */
    public $t_dataobject;

    /**
     * @var object
     */
    public $t_object;

    /**
     * @var null
     */
    public $t_null;

    /**
     * @var callable
     */
    public $t_callable;

}
