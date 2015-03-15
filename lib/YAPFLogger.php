<?php
/**
 * Description of YAPFLogger
 *
 * @author satch
 */
openlog( 'YAPF', LOG_PID, LOG_LOCAL1 );
define( 'DEFAULT_LOG_LEVEL', LOG_DEBUG );

abstract class YAPFLogger {

    /**
     *
     * @param type $in_nLevel
     * @param type $in_mMess
     *
     * @TODO : filtrer les log en fonction du niveau
     */
    public static function log( $in_nLevel = LOG_DEBUG, $in_mMess = '' ) {
        // test du niveau de debug
        syslog( LOG_ALERT, DEFAULT_LOG_LEVEL . ' >= ' . $in_nLevel );
        if ( DEFAULT_LOG_LEVEL >= $in_nLevel ) {

            // si le message est un tableau, il faut l'afficher
            if ( is_array( $in_mMess ) ) {
                $in_mMess = print_r( $in_mMess, true );
            }
            syslog( $in_nLevel, $in_mMess );
        }
    }
}
