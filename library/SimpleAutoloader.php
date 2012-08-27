<?php

/**
 * A simple autoloader following the PSR-0 standard.
 *
 * @author merten.vg
 */
class SimpleAutoloader
{
    
    protected $customAutoloadHandler = null;

    /**
     * Default constructor
     */
    public function __construct()
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
        if(!is_null($custom_auto_loader) && is_callable($custom_auto_loader)) {
            $this->customAutoloadHandler = $callable;
        }

        return $this;
    }

    public function autoloadHandler($object)
    {
        if (!is_null($customAutoloadHandler)) {
            $customAutoloadHandler($object);
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

        if($class_path !== false) {
            include $class_path;
            return true;
        }
        else {
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
        if(empty($paths) || !is_array($paths)) return;

        $valid = array();

        foreach($paths as $path) {
            $globs = glob($path, GLOB_ONLYDIR);
            if(is_array($globs) && !empty($globs)) {
                foreach($globs as $final) {
                    $valid[] = $final;
                }
            }
        }

        $valid[] = get_include_path();

        set_include_path(implode(PATH_SEPARATOR, $valid));

        return $this;
    }

}
