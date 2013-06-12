<?php

/**
 * Class NoDocEntity
 */
class NoDocEntity extends \Entity\Entity
{
    public static $testStatic = 'electrifying';

    public $testBool = false;

    public $testBoolean = true;

    public $testInteger = 12345;

    public $testInt = 67890;

    public $testFloat = 12.123;

    public $testDouble = 34.345;

    public $testNumeric = 34567;

    public $testLong = 23456;

    public $testReal = 56.567;

    public $testResource;

    public $testScalar = 'make it count! make it scalar!';

    public $testString = 'When life throws you a bone. Chew it.';

    public $testMixed = 'This could be anything really';

    public $testArray = array('one', 2, 'three');

    public $testStdClass;

    public $testEntityMarshal;

    public $testObject;

    public $testNull = null;

    public $testCallable = array('\Entity\ForeignScope', 'getInstance');

    public $testTypedArray1 = array();

    public $testTypedArray2 = array();

    public $testTypedArray3 = array(
        array('one', 2, 'three'),
        array('four', 5, 'six'),
    );

    public $testTypedArray4 = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29);
}
