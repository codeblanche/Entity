<?php

require __DIR__.'/src/Autoload/SimpleAutoloader.php';

Autoload\SimpleAutoloader::getInstance()
    ->addPaths(array(
        __DIR__.'/src',
        __DIR__.'/vendor',
    ));
