<?php

function __yapfAutoload( $classname ) {
    echo "Try autoloading $classname\n";
}

spl_autoload_register('__yapfAutoload' );