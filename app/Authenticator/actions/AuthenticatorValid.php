<?php


class AuthenticatorValid extends Action {

    public static function run( & $in_aConfig, &$out_aData = array(), &$in_aParameters = array() ) {
        $l_nResult = parent::run( $in_aConfig, $out_aData, $in_aParameters );

        if ( self::SUCCESS != $l_nResult ) {
            // on est KO, on recharge
            return 'error';
        }

        // on est OK, on valide par rapport à la BD
        if ( User::get( self::$_aParameters[ 'login' ], self::$_aParameters[ 'password' ] ) ) {
            
        }
        session_start();
        print_r( $_SESSION );
        die;
        $_SESSION[ 'userToken' ] = microtime( true );

        // on redirige sur l'URL de départ
        header( 'Location: ' . $_SESSION[ 'URL' ] );
        exit;


        echo "<hr>CONF<hr>";
        print_r( self::$_aConf );
        print_r( $in_aParameters );
        YAPFLogger::log( LOG_DEBUG, 'running action AuthenticatorValid' );

        // on cherche en BD si le user existe
    }

}
