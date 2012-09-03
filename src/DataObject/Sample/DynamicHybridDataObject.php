<?php

namespace DataObject\Sample;

use DataObject\HybridDataObject as AbstractHybridDataObject;
use DataObject\PermitDynamicPropertiesInterface;

/**
 * A sample DataObject using all known property types.
 *
 * @author     Merten van Gerven
 * @package    DataObject
 */
class DynamicHybridDataObject extends AbstractHybridDataObject implements PermitDynamicPropertiesInterface
{

    /**
     * @var bool
     */
    public $testBool = false;

    /**
     * @var boolean Alias of bool
     */
    private $testBoolean = true;

    /**
     * @var integer Alias of int
     */
    protected $testInteger = 12345;

    /**
     * @var int
     */
    public $testInt = 67890;

    /**
     * @var float
     */
    private $testFloat = 12.123;

    /**
     * @var double Alias of float
     */
    protected $testDouble = 34.345;

    /**
     * @var numeric
     */
    public $testNumeric = 34567;

    /**
     * @var long Alias of int
     */
    private $testLong = 23456;

    /**
     * @var real Aliss of float
     */
    protected $testReal = 56.567;

    /**
     * @var resource
     */
    public $testResource;

    /**
     * @var scalar Basix data type including int, float, string, bool
     */
    private $testScalar;

    /**
     * @var string
     */
    protected $testString = "test string";

    /**
     * @var mixed
     */
    public $testMixed ;

    /**
     * @var array
     */
    private $testArray = array('1', '2', '3');

    /**
     * @var stdClass
     */
    protected $testStdClass;

    /**
     * @var DataObject\SampleDataObject
     */
    public $testDataObject;

    /**
     * @var object
     */
    private $testObject;

    /**
     * @var null
     */
    protected $testNull;

    /**
     * @var callable
     */
    public $testCallable;

    /**
     * @var DataObject\SampleDataObject[]
     */
    private $testTypedArray1;

    /**
     * @var array<DataObject\SampleDataObject>
     */
    protected $testTypedArray2;

    /**
     * @var array[]
     */
    public $testTypedArray3;

    /**
     * @var integer[]
     */
    private $testTypedArray4;

}
