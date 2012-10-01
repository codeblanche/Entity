<?php

require __DIR__.'/vendor/Autoload/SimpleAutoloader.php';

Autoload\SimpleAutoloader::getInstance()->addPaths(
    array(
        __DIR__.'/src',
        __DIR__.'/vendor',
    )
);

