<?php

namespace EntityMarshalExample;

/**
 * A sample EntityMarshal using all known property types.
 *
 * @author     Merten van Gerven
 * @package    EntityMarshal
 */
class StdHybridMarshaledEntity extends \EntityMarshal\Entity\Marshaled\HybridEntity
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
     * @var scalar Basix data type including int, float, string, bool
     */
    public $testScalar;

    /**
     * @var string
     */
    public $testString = "test string";

    /**
     * @var mixed
     */
    public $testMixed;

    /**
     * @var array
     */
    public $testArray = array('1', 2, '3');

    /**
     * @var \stdClass
     */
    public $testStdClass;

    /**
     * @var \EntityMarshal\Entity\Marshaled\HybridEntity
     */
    public $testEntityMarshal;

    /**
     * @var object
     */
    public $testObject;

    /**
     * @var null
     */
    public $testNull;

    /**
     * @var callable
     */
    public $testCallable;

    /**
     * @var \EntityMarshal\Entity\Marshaled\HybridEntity[]
     */
    public $testTypedArray1;

    /**
     * @var array<\EntityMarshal\Entity\Marshaled\HybridEntity>
     */
    public $testTypedArray2;

    /**
     * @var array[]
     */
    public $testTypedArray3;

    /**
     * @var integer[]
     */
    public $testTypedArray4;

    /**
     * @param bool $value
     * @return HybridEntityMarshal
     */
    public function setTestBool($value)
    {
        $this->testBool = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return HybridEntityMarshal
     */
    public function setTestString($value)
    {
        $this->testString = $value;

        return $this;
    }
}

