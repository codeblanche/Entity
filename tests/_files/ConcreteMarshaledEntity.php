<?php

/**
 * Description of ConcreteMarshaledEntity
 *
 * @author merten
 */
class ConcreteMarshaledEntity extends \EntityMarshal\AbstractMarshaledEntity
{
    /**
     * @var boolean
     */
    public $isOk = true;

    /**
     * @var float
     */
    public $var1 = 'test1';

    /**
     * @var integer
     */
    public $var2 = 'test2';

    /**
     * @var string
     */
    public $var3 = 'test3';

    public $var4 = 'test4';

    /**
     * @var string[]
     */
    public $gen1;

    /**
     * @var array<string>
     */
    public $gen2;

    /**
     * @var \ConcreteEntity
     */
    public $ent1;

    /**
     * @var \stdClass
     */
    public $obj1;

    /**
     * @var array
     */
    public $arr1;

    /**
     * @var object
     */
    public $obj2;

    /**
     * @var null
     */
    public $nil1;


    /**
     * @return string
     */
    public static $ignoreStatic = 'this should be ignored';

    protected function defaultPropertyType()
    {
        return 'mixed';
    }

    protected function defaultValues()
    {
        return array(
            'isOk' => true,
            'var1' => '1.234',
            'var2' => '1234',
            'var3' => 'test3',
            'var4' => 'test4',
            'gen1' => null,
            'gen2' => null,
            'ent1' => null,
            'obj1' => null,
            'arr1' => null,
            'obj2' => null,
            'nil1' => null,
        );
    }

    protected function propertiesAndTypes()
    {
        return array(
            'isOk' => 'boolean',
            'var1' => 'float',
            'var2' => 'integer',
            'var3' => 'string',
            'var4' => null,
            'gen1' => 'string[]',
            'gen2' => 'array<string>',
            'ent1' => '\ConcreteEntity',
            'obj1' => '\stdClass',
            'arr1' => 'array',
            'obj2' => 'object',
            'nil1' => 'null',
        );
    }

    public function calledClassName()
    {
        return '\\'.__CLASS__;
    }

    public function triggerReflectProperties($filter = null)
    {
        return $this->reflectProperties($filter);
    }
}
