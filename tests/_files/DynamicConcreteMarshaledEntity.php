<?php

/**
 * Description of ConcreteMarshaledEntity
 *
 * @author merten
 */
class DynamicConcreteMarshaledEntity extends \EntityMarshal\AbstractMarshaledEntity implements
    \EntityMarshal\DynamicPropertyInterface
{
    protected function defaultPropertyType()
    {
        return 'mixed';
    }

    protected function defaultValues()
    {
        return array(
        );
    }

    protected function propertiesAndTypes()
    {
        return array(
        );
    }

    public function calledClassName()
    {
        return '\\'.__CLASS__;
    }
}
