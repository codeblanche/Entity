<?php
if (defined("DS") === false) {
    define("DS", DIRECTORY_SEPARATOR);
}

define("TEST_ROOT", dirname(__FILE__));
define("FILE_ROOT", TEST_ROOT.DS.'Files');
define("LIB_ROOT", dirname(dirname(__FILE__)).DS.'Library');


define("PAYNL_PROGRAMID", 352);
define("PAYNL_USERNAME", "api");
define("PAYNL_PASSWORD", "handshakeapi");

include LIB_ROOT.DS.'Autoloader.php';

Autoloader::getInstance()
    ->addBasePath('Paynl', LIB_ROOT.DS.'vendors');