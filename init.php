<?php
define("APP_ROOT", dirname(__FILE__));

require APP_ROOT.'/library/Autoloader.php';

Autoloader::getInstance()
    ->addBasePath('/', APP_ROOT.'/library');