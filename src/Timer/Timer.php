<?php

namespace Timer;

use DataObject\ObjectPropertyDataObject;

/**
 * @author     Merten van Gerven
 * @package    Timer
 */
final class Timer extends ObjectPropertyDataObject {

    /**
     * Microtime at start.
     *
     * @var float
     */
    protected $_start;

    /**
     * Microtime at stop.
     *
     * @var float
     */
    protected $_end;

    /**
     * Difference between start and end in microseconds.
     *
     * @var integer
     */
    protected $_diff;

    /**
     * Number of seconds between start and end.
     *
     * @var integer
     */
    public $seconds = 0;

    /**
     * Number of milliseconds between start and end.
     *
     * @var integer
     */
    public $milliseconds = 0;

    /**
     * Number of microseconds between start and end.
     *
     * @var integer
     */
    public $microseconds = 0;

    /**
     * Start the timer.
     *
     * @return Timer
     */
    public function start() {
        $this->_start = microtime(true);

        return $this;
    }

    /**
     * Stop the timer and set the results into seconds, milliseconds, and microseconds.
     *
     * @return Timer
     */
    public function stop() {
        $this->_end = microtime(true);
        $this->_diff = $this->_end - $this->_start;
        $this->microseconds = floor($this->_diff * 1000000);
        $this->milliseconds = floor($this->_diff * 1000);
        $this->seconds = floor($this->_diff);

        return $this;
    }

    /**
     * Make a new timer and return the intance.
     *
     * @param boolean $auto_start Automatically start the timer.
     *
     * @return Timer
     */
    public static function Make($auto_start = true) {
        $timer = new Timer();
        if($auto_start) {
            $timer->start();
        }
        return $timer;
    }

    /**
     * End the specified timer. Can also use $timer->stop();
     *
     * @param Timer $timer Timer instance
     *
     * @return integer The number of milliseconds between start and stop of timer.
     */
    public static function End(Timer $timer) {
        $timer->stop();
        return $timer->milliseconds;
    }
}

