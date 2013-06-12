<?php

/**
 * Class MortadellaEntity
 * @method MortadellaEntity setTestBool(bool $value)
 * @method bool getTestBool()
 * @method MortadellaEntity setTestBoolean(boolean $value)
 * @method boolean getTestBoolean()
 * @method MortadellaEntity setTestInteger(integer $value)
 * @method integer getTestInteger()
 * @method MortadellaEntity setTestInt(int $value)
 * @method int getTestInt()
 * @method MortadellaEntity setTestFloat(float $value)
 * @method float getTestFloat()
 * @method MortadellaEntity setTestDouble(double $value)
 * @method double getTestDouble()
 * @method MortadellaEntity setTestNumeric(numeric $value)
 * @method numeric getTestNumeric()
 * @method MortadellaEntity setTestLong(long $value)
 * @method long getTestLong()
 * @method MortadellaEntity setTestReal(real $value)
 * @method real getTestReal()
 * @method MortadellaEntity setTestResource(resource $value)
 * @method resource getTestResource()
 * @method MortadellaEntity setTestScalar(scalar $value)
 * @method scalar getTestScalar()
 * @method MortadellaEntity setTestString(string $value)
 * @method string getTestString()
 * @method MortadellaEntity setTestMixed(mixed $value)
 * @method mixed getTestMixed()
 * @method MortadellaEntity setTestArray(array $value)
 * @method array getTestArray()
 * @method MortadellaEntity setTestStdClass(\stdClass $value)
 * @method \stdClass getTestStdClass()
 * @method MortadellaEntity setTestEntityMarshal(MortadellaEntity $value)
 * @method MortadellaEntity getTestEntityMarshal()
 * @method MortadellaEntity setTestObject(object $value)
 * @method object getTestObject()
 * @method MortadellaEntity setTestNull(null $value)
 * @method null getTestNull()
 * @method MortadellaEntity setTestCallable(callable $value)
 * @method callable getTestCallable()
 * @method MortadellaEntity setTestTypedArray1(array $value)
 * @method array getTestTypedArray1()
 * @method MortadellaEntity setTestTypedArray2(array $value)
 * @method array getTestTypedArray2()
 * @method MortadellaEntity setTestTypedArray3(array $value)
 * @method array getTestTypedArray3()
 * @method MortadellaEntity setTestTypedArray4(array $value)
 * @method array getTestTypedArray4()
 */
class MortadellaEntity extends \Entity\Entity
{
    /**
     * @var string
     */
    public static $testStatic = 'electrifying';

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
    public $testString = 'When life throws you a bone. Chew it.';

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
     * @var MortadellaEntity
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
    public $testCallable = array('\Entity\Utils', 'makeSetterGetterDoc');

    /**
     * @var object[]
     */
    public $testTypedArray1 = array();

    /**
     * @var array<MortadellaEntity>
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
