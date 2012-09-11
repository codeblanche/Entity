<?php

require __DIR__.'/src/Autoload/SimpleAutoloader.php';

Autoload\SimpleAutoloader::get()
    ->addPaths(array(
        __DIR__.'/src',
    ));
