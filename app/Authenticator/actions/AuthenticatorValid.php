<?php


class AuthenticatorValid extends Action {

    public static function run( & $in_aConfig, &$in_aParameters = array(), &$out_aData = array() ) {
        parent::run( $in_aConfig, $out_aData );
        print_r( self::$_aConf );
        YAPFLogger::log( LOG_DEBUG, 'running action AuthenticatorValid' );
    }

}
