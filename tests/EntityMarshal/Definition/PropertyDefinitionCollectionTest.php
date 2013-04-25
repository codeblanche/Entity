<?php

namespace EntityMarshal\Definition;

class PropertyDefinitionCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyDefinitionCollection
     */
    protected $obj;

    public function testAddHasGet()
    {
        
    }

    public function testKeys()
    {

    }

    public function testImportExport()
    {

    }

    protected function setUp()
    {
        $this->obj = new PropertyDefinitionCollection(new PropertyDefinition());
    }
}
