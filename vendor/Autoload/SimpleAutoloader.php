<?php

namespace Autoload;

use \Autoload\Exception\RuntimeException;

/**
 * A simple autoloader following the PSR-0 standard.
 *
 * @author     Merten van Gerven
 * @package    Autoload
 */
class SimpleAutoloader
{
    /**
    * @var callable Custom autoload handler... see that... it's the same but with spaces.
    */
    protected $customAutoloadHandler;

    /**
    * @var SimpleAutoloader Singleton instance.
    */
    private static $instance;

    /**
    * SimpleAutoloader singleton factory method.
    *
    * @return SimpleAutloader
    */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            $self             = __CLASS__;
            static::$instance = new $self();
        }

        return static::$instance;
    }

    /**
     * Default constructor
     */
    private function __construct()
    {
        spl_autoload_register(array($this, 'autoloadHandler'));
    }

    /**
     * Set a custom autoload handler function
     *
     * @param callable $customHandler Optional name of custom loader function.
     */
    public function setCustomAutoloadHandler($callable = null)
    {
        if (!is_null($callable) && !is_callable($callable)) {
            throw new RuntimeException("Expected non-null argument to be callable.");
        }

        $this->customAutoloadHandler = $callable;

        return $this;
    }

    /**
    * put your comment there...
    *
    * @param mixed $object
    */
    protected function autoloadHandler($object)
    {
        if (!is_null($this->customAutoloadHandler)) {
            $this->customAutoloadHandler($object);
        } else {
            $this->defaultAutoloadHandler($object);
        }
    }

    /**
     * Loads a class. Simples!
     *
     * @param string $object name of the class to load.
     */
    protected function defaultAutoloadHandler($object)
    {
        $object = str_replace('\\', '/', $object);
        $class_path = str_replace('_', '/', $object) . '.php';
        $class_path = stream_resolve_include_path($class_path);

        if ($class_path !== false) {
            include $class_path;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Add the array of paths to the include path list. Glob patterns are supported.
     *
     * @param array $paths
     *
     * @return null
     */
    public function addPaths(array $paths)
    {
        if (empty($paths) || !is_array($paths)) {
            throw new RuntimeException("Expected argument to be an array with at least one path entry.");
        }

        $valid = array();

        foreach ($paths as $path) {
            $globs = glob($path, GLOB_ONLYDIR);
            if (is_array($globs) && !empty($globs)) {
                foreach ($globs as $final) {
                    $valid[] = $final;
                }
            }
        }

        $valid[] = get_include_path();

        set_include_path(implode(PATH_SEPARATOR, $valid));

        return $this;
    }

}
