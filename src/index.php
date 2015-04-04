<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', 'On' );

// le controlleur
require '../lib/Controller.php';
Controller::run();
//    YAPF\Controller\Controller::run( array_slice( explode( '/', $_SERVER[ 'REQUEST_URI' ] ), 1 ) );
