<?php

/**
 * Description of ConcreteMarshaledEntity
 *
 * @author merten
 */
class InvalidConcreteMarshaledEntityB extends \EntityMarshal\AbstractMarshaledEntity
{
    /**
     * @var \RedwoodOriginal[]
     */
    public $varMixed = true;

    protected function defaultPropertyType()
    {
        return 'mixed';
    }

    protected function defaultValues()
    {
        return array(
            'varMixed' => true,
        );
    }

    protected function propertiesAndTypes()
    {
        return array(
            'varMixed' => '\RedwoodOriginal[]',
        );
    }

    public function calledClassName()
    {
        return '\\'.__CLASS__;
    }
}
