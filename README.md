Entity v1.0.2
============

All for Entity, and Entity for all.

More documentation coming soon.

Example
-------

See `fixtures/*` for other examples. The most complete of these being `MortadellaEntity`.

```php

class MyEntity extends \Entity\Entity
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
     * @var Entity\Sample\ObjectPropertyEntityMarshal[]
     */
    public $testTypedArray1;

    /**
     * @var array<Entity\Sample\ObjectPropertyEntityMarshal>
     */
    public $testTypedArray2;

    /**
     * @var integer[]
     */
    public $testTypedArray4;

}

```
