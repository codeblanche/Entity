<?php
/**
 * Created by JetBrains PhpStorm.
 * User: merten
 * Date: 4/25/13
 * Time: 10:17 PM
 * To change this template use File | Settings | File Templates.
 */

namespace EntityMarshal;

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
}
