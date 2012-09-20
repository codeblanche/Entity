<?php

namespace EntityMarshal\Convert;

use Countable;
use EntityMarshal\EntityInterface;

/**
* Convert and entity to a Dump string
*
* @package      EntityMarshal\ConverterStrategy
*/
class Dump extends AbstractConvert
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
     * @param   string  $html       Output with(out) html
     * @param   string  $maxDepth   Maximum recursion depth (0 = no limit)
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

        return $this->html
            ? "<pre style='color:#555;'>\n{$result}\n</pre>"
            : strip_tags($result);
    }

    /**
     * @param array|EntityInterface $data   Value
     * @param string                $name   Name
     *
     * @return array
     */
    protected function recurse(&$data, $name = null, $type = null, $generics_type = null)
    {
        $lpad = str_repeat($this->indentWith, $this->depth);

        if ($this->maxDepth > 0 && $this->depth > $this->maxDepth) {
            $this->out[] = "{$lpad}<em style='color:#999;'>...</em>";
            return;
        }

        if ($this->isCircularReference($data)) {
            $this->out[] = "{$lpad}<em style='color:#999;'> ... cirular reference detected</em>";
            return;
        }

        if (is_array($data)) {
            $len  = count($data);
            $type = 'array';

            $this->out[] = "{$this->makeDefinition($type, $len, $name)} [";

            $this->depth++;

            foreach ($data as $key => $val) {
                $this->recurse($val, $key);
            }

            $this->depth--;

            $this->out[] = "{$lpad}]";

        } elseif (is_object($data)) {
            if (!($data instanceof EntityInterface)) {
                $data = get_object_vars($data);
            }

            $len = count($data);

            $this->out[] = "{$this->makeDefinition($type, $len, $name)} {";

            $this->depth++;

            foreach ($data as $key => $val) {
                $valType = null;
                if (is_object($val)) {
                    if ($val instanceof EntityInterface) {
                        $valType = $data->typeof($key);
                    } else {
                        $valType = get_class($val);
                    }
                }

                $this->recurse($val, $key, $valType);
            }

            $this->depth--;

            $this->out[] = "{$lpad}}";

        } else {
            $this->convertScalar($data, $name, $type);

        }



//
//        foreach ($array as $key => $val) {
//            $type = gettype($val);
//
//            $defined_type     = isset($this->definitionTypes[$key]) ? $this->definitionTypes[$key] : $type;
//            $generics_subtype = null;
//
//            if (isset($this->definitionGenerics[$key])) {
//                $generics_subtype = $this->definitionGenerics[$key];
//                $defined_type = "{$generics_subtype}[]";
//            }
//
//            if (!is_null($generics_type)) {
//                $defined_type = $generics_type;
//            }
//
//            if (in_array($type, array('array', 'object'))) {
//                $recurse = !$this->isCircularReference($val);
//                $len     = count($val);
//                $sub     = array();
//
//                if ($type === 'object' && $val instanceof EntityMarshal) {
//                    $sub    = $val->dump(true, true, $prefix);
//                    $sub[0] = str_replace($prefix, "$prefix [<span style='color:#090;'>$key</span>]", $sub[0]);
//                    $out    = array_merge($out, $sub);
//                } else {
//                    $out[]   = "$prefix [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) {";
//                    $prefix .= str_pad('', 4);
//
//                    $sub = $this->dumpArray($val, $prefix, $generics_subtype);
//                    $out = array_merge($out, $sub);
//
//                    $out[]  = "$prefix }";
//                    $prefix = substr($prefix, 0, -4);
//                }
//            } else {
//                $len = strlen($val);
//
//                if ($type === 'string') {
//                    $val = "\"$val\"";
//                } elseif (is_bool($val)) {
//                    $val = $val ? 'true' : 'false';
//                } elseif (is_null($val)) {
//                    $val = "<em style='color:#999;'>null</em>";
//                }
//
//                $out[] = "$lpad [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) => <span style='color:#a00;'>$val</span>";
//            }
//        }
//
        return $out;
    }

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
     * @param type $value
     */
    protected function convertScalar($value, $name, $type = null)
    {
        $len    = strlen($value);

        if (is_null($type)) {
            $type = strtolower(gettype($value));
        }

        if ($type === 'string') {
            $value = "\"$value\"";
        } elseif (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } elseif (is_null($value)) {
            $value = "<em style='color:#999;'>null</em>";
        }

        $this->out[] = "{$this->makeDefinition($type, $len, $name)} => <span style='color:#a00;'>$value</span>";
    }

    /**
     *
     */
//    protected function initTypesAndGenerics()
//    {
//        if (!($this->objectType instanceof EntityMarshalInterface)) {
//            return;
//        }
//
//        $entity = new $this->objectType; /* @var $entity EntityMarshalInterface */
//
//        $this->definitionTypes = $entity->propertiesAndTypes();
//
//        foreach ($this->definitionTypes as $key => $type) {
//            $subType = AbstractEntityMarshal::extractGenericSubtype($type);
//            if (!is_null($subType)) {
//                $this->definitionGenerics[$key] = $subType;
//                $this->definitionTypes[$key]    = 'array';
//            }
//        }
//    }





    /**
     * Output dump of properties handled by EntityMarshal.
     *
     * @param boolean $html
     * @param boolean $return
     * @param string  $prefix
     */
//    final public function dump($html = true, $return = false, $prefix = '')
//    {
//        $out = array();
//
//        $len = count($this->definitionKeys);
//        $out[] = "$prefix <span style='color:#00a;'>$this->calledClass</span> ($len) {";
//        $prefix .= str_pad('', 4);
//
//        $out = array_merge($out, $this->dumpArray($this->definitionValues, $prefix));
//
//        $out[] = "$prefix }";
//        $prefix = substr($prefix, 0, -4);
//
//        if ($return) {
//            return $out;
//        } else {
//            $result = PHP_EOL . implode(PHP_EOL, $out) . PHP_EOL;
//            echo $html ? "<pre style='color:#555;'>$result</pre>" : strip_tags($result);
//        }
//    }

    /**
     * Process array for dump output.
     *
     * @param array  $array
     * @param string $prefix
     *
     * return array
     */
//    final protected function dumpArray(&$array, $prefix = '', $generics_type = null)
//    {
//        $out = array();
//        foreach ($array as $key => $val) {
//            if (isset($this->$key) && !empty($this->$key)) {
//                $val = $this->$key;
//            }
//
//            $type = gettype($val);
//
//            $defined_type     = isset($this->definitionTypes[$key]) ? $this->definitionTypes[$key] : $type;
//            $generics_subtype = null;
//
//            if (isset($this->definitionGenerics[$key])) {
//                $generics_subtype = $this->definitionGenerics[$key];
//                $defined_type = "{$generics_subtype}[]";
//            }
//
//            if (!is_null($generics_type)) {
//                $defined_type = $generics_type;
//            }
//
//            if (in_array($type, array('array', 'object'))) {
//                $len = count($val);
//                $sub = array();
//
//                if ($type === 'object' && $val instanceof AbstractEntity) {
//                    if ($val === $this) {
//                        die('Possible endless recursion triggered.');
//                    }
//                    $sub    = $val->dump(true, true, $prefix);
//                    $sub[0] = str_replace($prefix, "$prefix [<span style='color:#090;'>$key</span>]", $sub[0]);
//                    $out    = array_merge($out, $sub);
//                } else {
//                    $out[]   = "$prefix [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) {";
//                    $prefix .= str_pad('', 4);
//
//                    $sub = $this->dumpArray($val, $prefix, $generics_subtype);
//                    $out = array_merge($out, $sub);
//
//                    $out[]  = "$prefix }";
//                    $prefix = substr($prefix, 0, -4);
//                }
//            } else {
//                $len = strlen($val);
//                if ($type === 'string') {
//                    $val = "\"$val\"";
//                } elseif (is_bool($val)) {
//                    $val = $val ? 'true' : 'false';
//                } elseif (is_null($val)) {
//                    $val = "<em style='color:#999;'>null</em>";
//                }
//                $out[] = "$prefix [<span style='color:#090;'>$key</span>] <span style='color:#00a;'>$defined_type</span> ($len) => <span style='color:#a00;'>$val</span>";
//            }
//        }
//
//        return $out;
//    }
}

