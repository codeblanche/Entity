<?php

require __DIR__.'/../init.php';

Autoload\SimpleAutoloader::get()
    ->addPaths(array(
        __DIR__,
        __DIR__.'/../samples/'
    ));
