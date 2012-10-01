<?php

/**
 * Description of ConcreteMarshaledEntity
 *
 * @author merten
 */
class InvalidConcreteMarshaledEntityA extends \EntityMarshal\AbstractMarshaledEntity
{
    /**
     * @var boolean|string
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
            'varMixed' => 'boolean|string',
        );
    }

    public function calledClassName()
    {
        return '\\'.__CLASS__;
    }
}
