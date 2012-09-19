<?php

require __DIR__.'/../init.php';

Autoload\SimpleAutoloader::getInstance()
    ->addPaths(array(
        __DIR__,
        __DIR__.'/../samples/'
    ));
