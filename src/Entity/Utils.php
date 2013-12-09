<?php
/**
 * Created by JetBrains PhpStorm.
 * User: merten
 * Date: 4/25/13
 * Time: 10:17 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Entity;

class Utils
{

    /**
     * Generate the setter and getter method PHPDoc declaration to paste into your entity class.
     *
     * @param Entity $entity
     */
    public static function makeSetterGetterDoc(Entity $entity)
    {
        $properties = $entity->toArray(false);
        $entityName = $entity->calledClassName();

        echo "<pre>\n";

        foreach ($properties as $name => $value) {
            $methodName = ucfirst($name);
            $type       = $entity->typeof($name);

            echo " * @method $entityName set$methodName($type \$value)\n";
            echo " * @method $type get$methodName()\n";
        }
        echo "</pre>\n";
    }

    /**
     * Generate the public properties PHPDoc declarations to paste into your entity class.
     * @param array $properties
     */
    public static function makePublicProperties(array $properties)
    {
        echo '<pre>'."\n";

        foreach ($properties as $key => $value)
        {
            $type = gettype($value);

            if ($type === 'object') {
                $type = get_class($value);
            }

            echo <<<EODOC
    /**
     * @var $type
     */
    public \$$key;

EODOC;
        }

        echo '</pre>'."\n";
    }
}
