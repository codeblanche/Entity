<?php

namespace Entity\Abstraction;

interface SortableInterface
{
    /**
     * Sort the object by value
     *
     * @return bool
     */
    public function asort();

    /**
     * Sort the object by property/key
     *
     * @return bool
     */
    public function ksort();

    /**
     * Sort the object by value using natural order (case insensitive)
     *
     * @return bool
     */
    public function natcasesort();

    /**
     * Sort the object by value using natural order
     *
     * @return bool
     */
    public function natsort();

    /**
     * Sort the object by value with a user defined function
     *
     * @param callable $cmp_function
     *
     * @return bool
     */
    public function uasort(callable $cmp_function);

    /**
     * Sort the object by property/key with a user defined function
     *
     * @param callable $cmp_function
     *
     * @return bool
     */
    public function uksort(callable $cmp_function);
} 
