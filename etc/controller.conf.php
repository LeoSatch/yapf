<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define( '_CLASS_SUFFIXE', '.php' );


abstract class ParametersSettings {
    protected static $backends = array();
    protected static $fields = array();
    protected static $configuration = array();
    protected static $templates = array();

    /**
     * tableau indexe comme ceci : [app][module][paramName] = array( 'name' => 'xxx', 'regex' => 'XXX' );
     *
     */
    public static $parametersValidation = array();

    public static function init( $in_sAppName ) {
        // load constantes if any
        if ( file_exists( _APP_CONF_DIR . 'constantes.php' ) ) {
            require_once _APP_CONF_DIR . 'constantes.php';
        }
        // load global conf
        // load app conf
        foreach ( glob( _APP_CONF_DIR . '*.conf.php' ) as $l_sFilename ) {
            list( $varname, ) = explode( '.', basename( $l_sFilename ) );
            require $l_sFilename;
            self::${$varname} = ${$varname};
        }
    }

    /**
     *
     * @return boolean
     */
    public static function needsAuth() {
        if ( array_key_exists( 'authNeeded', self::$configuration ) ) {
            return self::$configuration[ 'authNeeced' ];
        }

        return false;
    }



    public static function getBackends() {
        return static::$backends;
    }

}
