<?php

/**
 * Description of ConcreteEntity
 *
 * @author merten
 */
class ConcreteEntity extends \EntityMarshal\AbstractEntity
{
    /**
     * {@inheritdoc}
     */
    protected function defaultValues()
    {
        return array(
            'isOk' => true,
            'var1' => 'test1',
            'var2' => 'test2',
            'var3' => 'test3',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function calledClassName()
    {
        return __CLASS__;
    }

    /**
     * Trigger the protected unset properties method
     *
     * @param   array       $keys
     */
    public function triggerUnsetProperties($keys = [])
    {
        $this->unsetProperties($keys);
    }

    /**
     * Trigger the protected call method.
     *
     * @param   string      $method     Name of the method to call
     * @param   array       $arguments  Arguments to the method
     * @return  mixed
     */
    public function triggerCall($method, $arguments = [])
    {
        return $this->call($method, $arguments);
    }
}

