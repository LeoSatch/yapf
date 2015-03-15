<?php

function debug( $message ) {
    if ( _ENV == 'dev' ) {
        if ( is_array( $message ) ) {
            $message = '<pre>' . print_r( $message, 1 ) . '</pre>';
        }
        echo $message;
    }
}
