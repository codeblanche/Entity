<?php
namespace Paynl\DataObject;

abstract class Cloneable {

    function __clone() {
        $this->_clone_recursive($this);
    }

    private function _clone_recursive(&$collection) {
        if(is_array($collection) || is_object($collection)) {
            foreach($collection as $key=>$value){
                if ( is_array($value) ) {
                    $this->_clone_recursive($value);
                }
                else if( is_object($value) ) {
                    if (is_array($collection) ) {
                        $collection[$key] = clone $value;
                    } else {
                        $collection->$key = clone $value;
                    }
                }
            }
        }
    }

}