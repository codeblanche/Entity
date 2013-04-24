EntityMarshal 0.1.0
===================

Example
-------

```php

class MyEntity extends \EntityMarshal\Entity\Marshaled\ObjectPropertyEntity
{

    /**
     * @var boolean Alias of bool
     */
    public $testBoolean = true;

    /**
     * @var integer Alias of int
     */
    public $testInteger = 12345;

    /**
     * @var string
     */
    public $testString = "test string";

    /**
     * @var mixed
     */
    public $testMixed ;

    /**
     * @var array
     */
    public $testArray = array('1', '2', '3');

    /**
     * @var EntityMarshal\Sample\ObjectPropertyEntityMarshal[]
     */
    public $testTypedArray1;

    /**
     * @var array<EntityMarshal\Sample\ObjectPropertyEntityMarshal>
     */
    public $testTypedArray2;

    /**
     * @var integer[]
     */
    public $testTypedArray4;

}

```
