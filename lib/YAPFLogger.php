<?php
/**
 * Description of YAPFLogger
 *
 * @author satch
 */
openlog( 'YAPF', LOG_PID, LOG_LOCAL6 );

abstract class YAPFLogger {

    public static function log( $in_nLevel = LOG_DEBUG, $in_mMess = '' ) {
        // si le message est un tableau, il faut l'afficher
        if ( is_array( $in_mMess ) ) {
            $in_mMess = print_r( $in_mMess, true );
        }
        syslog( $in_nLevel, $in_mMess );
    }

}
