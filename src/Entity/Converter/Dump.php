<?php

namespace Entity\Converter;

use Entity\Abstraction\EntityInterface;
use Entity\Converter\Abstraction\ConverterStrategy;

/**
 * Convert and entity to a Dump string
 *
 * @package      ConverterStrategy
 */
class Dump extends ConverterStrategy
{
    /**
     * @var boolean
     */
    protected $html = true;

    /**
     * @var string  Indentation string
     */
    protected $indentWith = '    ';

    /**
     * @var integer Current depth of dump process
     */
    protected $depth = 0;

    /**
     * @var integer Maximum nesting depth to dump (0 = no limit)
     */
    protected $maxDepth = 5;

    /**
     * @var array   Collection of output lines
     */
    private $out = array();

    /**
     * Configure the dump converter strategy
     *
     * @param boolean $html       Output with(out) html
     * @param integer $maxDepth   Maximum recursion depth (0 = no limit)
     */
    public function __construct($html = true, $maxDepth = 5)
    {
        $this->html     = $html;
        $this->maxDepth = $maxDepth;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(EntityInterface $entity)
    {
        $this->recurse($entity, null, $entity->calledClassName());

        $result = implode(PHP_EOL, $this->out);

        return $this->html ? "<pre style='color:#555;'>\n{$result}\n</pre>" : strip_tags($result);
    }

    /**
     * @param array|EntityInterface $data
     * @param string                $name
     * @param string                $type
     *
     * @return array
     */
    protected function recurse(&$data, $name = null, $type = null)
    {
        $lpad = str_repeat($this->indentWith, $this->depth);

        if ($this->maxDepth > 0 && $this->depth > $this->maxDepth) {
            $this->out[] = "{$this->makeDefinition(
                $type,
                null,
                $name
            )} <em style='color:#999;'>" . "... depth limit reached</em>";

            return;
        }

        if ($this->isCircularReference($data)) {
            $this->out[] = "{$this->makeDefinition(
                $type,
                null,
                $name
            )} <em style='color:#999;'>" . "... cirular reference omitted</em>";

            return;
        }

        if (is_array($data)) {
            $len  = count($data);
            $type = $type ? : 'array';

            $this->out[] = "{$this->makeDefinition($type, $len, $name)} {";

            $this->depth++;

            foreach ($data as $key => $val) {
                $valType = gettype($val);
                if ($val instanceof EntityInterface) {
                    $valType = $val->calledClassName();
                }
                elseif (is_object($val)) {
                    $valType = get_class($val);
                }

                $this->recurse($val, $key, $valType);
            }

            $this->depth--;

            $this->out[] = "{$lpad}}";
        }
        elseif (is_object($data)) {
            if (!($data instanceof EntityInterface)) {
                $data = get_object_vars($data);
            }

            $len  = count($data);
            $type = $type ? : get_class($data);

            $this->out[] = "{$this->makeDefinition($type, $len, $name)} {";

            $this->depth++;

            foreach ($data as $key => $val) {
                $valType = $data instanceof EntityInterface ? $data->typeof($key) : null;
                $this->recurse($val, $key, $valType);
            }

            $this->depth--;

            $this->out[] = "{$lpad}}";
        }
        else {
            $this->makeScalarDefinition($data, $name, $type);
        }
    }

    /**
     * @param string  $type
     * @param integer $len
     * @param string  $name
     *
     * @return string
     */
    protected function makeDefinition($type, $len = 0, $name = null)
    {
        $lpad     = str_repeat($this->indentWith, $this->depth);
        $namePart = '';

        if (!is_null($name) && $name !== '') {
            $namePart = "[<span style='color:#090;'>$name</span>] ";
        }

        return "{$lpad}{$namePart}<span style='color:#00a;'>{$type}</span> ({$len})";
    }

    /**
     * @param mixed  $value
     * @param string $name
     * @param string $type
     */
    protected function makeScalarDefinition($value, $name, $type = null)
    {
        $len  = strlen($value);
        $type = $type ? : strtolower(gettype($value));

        if ($type === 'string') {
            $value = "\"$value\"";
        }
        elseif (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        elseif (is_null($value)) {
            $value = "<em style='color:#999;'>null</em>";
        }

        $this->out[] = "{$this->makeDefinition($type, $len, $name)} => <span style='color:#a00;'>$value</span>";
    }
}

