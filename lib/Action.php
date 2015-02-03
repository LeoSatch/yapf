<?php

/**
 * Description of Action
 *
 * @author satch
 */
abstract class Action {

    protected static $_aConf = array();
    protected static $_aParameters = array();

    public static function run( & $in_aConfiguration, & $out_aData = array(), & $in_aParameters = array() ) {
        // la conf
        self::$_aConf = $in_aConfiguration;

        // les parametres
        self::$_aParameters = $in_aParameters;

        // doit-on etre identifie
        if ( array_key_exists( 'authNeeded', $in_aConfiguration ) && $in_aConfiguration[ 'authNeeded' ] ) {
            self::_authenticateUser( );
        }

        // validation des paramètres
        if ( !empty( $_POST ) ) {
            self::_parametersValidation( $in_aParameters );
        }
    }

    protected static function _authenticateUser() {
        session_start();
        if ( empty( $_SESSION ) || !isset( $_SESSION[ 'userToken' ] ) || $_SESSION[ 'userToken' ] != '' ) {
            // memoire de la page demandée
            $_SESSION[ 'URL' ] = $_SERVER[ 'REQUEST_URI' ];
            while ( !Authenticator::run( array() ) ) {
                
            }
        }
    }

    protected static function _loadConfiguration() {
        // on charge
        //require
    }

    /**
     *
     * @param array $in_aParameters
     */
    protected static function _parametersValidation( $in_aParameters ) {
        print_r( $in_aParameters );
        die;
        print_r( self::$_aConf[ 'parameters' ][ 'post' ] );
        foreach ( self::$_aConf[ 'parameters' ][ 'post' ] as $l_sParamName => $l_aParamData ) {
            YAPFLogger::log( LOG_DEBUG, 'validating parameter ' . $l_sParamName );
            if ( array_key_exists( 'regex', $l_aParamData ) ) {
                YAPFLogger::log( LOG_DEBUG, 'value = ' . $in_aParameters[ $l_sParamName ] );
                var_dump( preg_match( $l_aParamData[ 'regex' ], $in_aParameters[ $l_sParamName ] ) );
            }
        }

        die( 'fin valid' );
    }

}
