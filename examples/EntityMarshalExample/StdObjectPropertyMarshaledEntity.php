<?php

namespace EntityMarshalExample;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class StdObjectPropertyMarshaledEntity extends \EntityMarshal\Entity\Marshaled\ObjectPropertyEntity
{
    /**
     * @var bool
     */
    public $testBool = false;

    /**
     * @var boolean Alias of bool
     */
    public $testBoolean = true;

    /**
     * @var integer Alias of int
     */
    public $testInteger = 12345;

    /**
     * @var int
     */
    public $testInt = 67890;

    /**
     * @var float
     */
    public $testFloat = 12.123;

    /**
     * @var double Alias of float
     */
    public $testDouble = 34.345;

    /**
     * @var numeric
     */
    public $testNumeric = 34567;

    /**
     * @var long Alias of int
     */
    public $testLong = 23456;

    /**
     * @var real Aliss of float
     */
    public $testReal = 56.567;

    /**
     * @var resource
     */
    public $testResource;

    /**
     * @var scalar Basic data type including int, float, string, bool
     */
    public $testScalar = 'make it count! make it scalar!';

    /**
     * @var string
     */
    public $testString = 'When life throws you a bone. Give it to a dog.';

    /**
     * @var mixed
     */
    public $testMixed = 'This could be anything really';

    /**
     * @var array
     */
    public $testArray = array('one', 2, 'three');

    /**
     * @var \stdClass
     */
    public $testStdClass;

    /**
     * @var \EntityMarshal\Entity\Marshaled\ObjectPropertyEntity
     */
    public $testEntityMarshal;

    /**
     * @var object
     */
    public $testObject;

    /**
     * @var null
     */
    public $testNull = null;

    /**
     * @var callable
     */
    public $testCallable = array('\EntityMarshal\ForeignScope', 'getInstance');

    /**
     * @var \EntityMarshal\Entity\Marshaled\ObjectPropertyEntity[]
     */
    public $testTypedArray1 = array();

    /**
     * @var array<\EntityMarshal\Entity\Marshaled\ObjectPropertyEntity>
     */
    public $testTypedArray2 = array();

    /**
     * @var array[]
     */
    public $testTypedArray3 = array(
        array('one', 2, 'three'),
        array('four', 5, 'six'),
    );

    /**
     * @var integer[]
     */
    public $testTypedArray4 = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29);
}

