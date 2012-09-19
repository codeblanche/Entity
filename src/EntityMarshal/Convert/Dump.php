<?php

namespace EntityMarshal\Convert;

/**
* Convert and entity to a Dump string
*
* @package      EntityMarshal\ConverterStrategy
*
* @todo         IT'S BROKE! FIX IT!
*/
class Dump extends AbstractConvert
{
    /**
     * @var boolean
     */
    protected $html = true;

    /**
     * @var string Data type definition override
     */
    protected $objectType;

    /**
     * @var array Types of public properties declared within EntityMarshal extendor.
     */
    protected $definitionTypes = array();

    /**
     * @var array Generic types of public array/list properties declared within EntityMarshal extendor.
     */
    protected $definitionGenerics = array();

    /**
     * Configure the hash converter strategy
     *
     * @param string $type
     * @param string $prefix
     * @param string $suffix
     * @param array  $ignoreKeys Optional list of keys to ignore.
     */
    public function __construct($html = true)
    {
        $this->html = $html;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(array $data, $type = null)
    {
        $this->objectReferences = array();

        // temporarily disable Dump strategy.
        return $type;
//
//        $out = $this->convertRecursive($data, $type);
//
//        $result = implode(PHP_EOL, $out);
//
//        return $this->html
//            ? "<pre style='color:#555;'>\n{$result}\n</pre>"
//            : strip_tags($result);
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
     * @param array  $data
     * @param string $lpad
     *
     * @return array
     */
//    protected function convertRecursive(array &$data, EntityMarshalInterface $type = null, $lpad = '', $generics_type = null)
//    {
//        $out = array();
//
//        /*
//        array_unshift($out, "<span style='color:#00a;'>{$type}</span> ({$len}) {");
//        array_push($out, "}\n");
//         */
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
//        return $out;
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

