<?php

namespace EntityMarshalExample;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class StdClassMethodMarshaledEntity extends EntityMarshal\Entity\Marshaled\ClassMethodEntity
{
    /**
     * @var bool
     */
    protected $testBool = false;

    /**
     * @var boolean Alias of bool
     */
    protected $testBoolean = true;

    /**
     * @var integer Alias of int
     */
    protected $testInteger = 12345;

    /**
     * @var int
     */
    protected $testInt = 67890;

    /**
     * @var float
     */
    protected $testFloat = 12.123;

    /**
     * @var double Alias of float
     */
    protected $testDouble = 34.345;

    /**
     * @var numeric
     */
    protected $testNumeric = 34567;

    /**
     * @var long Alias of int
     */
    protected $testLong = 23456;

    /**
     * @var real Aliss of float
     */
    protected $testReal = 56.567;

    /**
     * @var resource
     */
    protected $testResource;

    /**
     * @var scalar Basix data type including int, float, string, bool
     */
    protected $testScalar;

    /**
     * @var string
     */
    protected $testString = "test string";

    /**
     * @var mixed
     */
    protected $testMixed ;

    /**
     * @var array
     */
    protected $testArray = array('1', '2', '3');

    /**
     * @var \stdClass
     */
    protected $testStdClass;

    /**
     * @var EntityMarshal\Entity\Marshaled\ClassMethodEntity
     */
    protected $testEntityMarshal;

    /**
     * @var object
     */
    protected $testObject;

    /**
     * @var null
     */
    protected $testNull;

    /**
     * @var callable
     */
    protected $testCallable;

    /**
     * @var EntityMarshal\Entity\Marshaled\ClassMethodEntity[]
     */
    protected $testTypedArray1;

    /**
     * @var array<EntityMarshal\Entity\Marshaled\ClassMethodEntity>
     */
    protected $testTypedArray2;

    /**
     * @var array[]
     */
    protected $testTypedArray3;

    /**
     * @var integer[]
     */
    protected $testTypedArray4;
}

