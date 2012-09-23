<?php

require __DIR__.'/../init.php';

Autoload\SimpleAutoloader::getInstance()->addPaths(
    array(
        __DIR__.'/src',
        __DIR__.'/examples',
        __DIR__.'/../examples',
    )
);

