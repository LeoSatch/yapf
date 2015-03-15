<?php

/**
 * Description of Action
 *
 * @author satch
 */
abstract class Action {

    protected static $_aConf = array();
    protected static $_aParameters = array();
    protected static $_aData = array();

    const SUCCESS = 1001;
    const ERROR_PARAM_KO = 2001;

    public static function run( & $in_aConfiguration, & $out_aData = array(), & $in_aParameters = array() ) {
        $l_nResult = static::SUCCESS;
        // la conf
        static::$_aConf = $in_aConfiguration;

        // les parametres
        static::$_aParameters = $in_aParameters;

        // validation des paramètres
        if ( !empty( $_POST ) ) {
            $l_nResult = static::_parametersValidation();
        }

        return $l_nResult;
    }


    protected static function _loadConfiguration() {
        // on charge
        //require
    }

    /**
     *
     * @param array $in_aParameters
     */
    protected static function _parametersValidation() {
        $l_bResult = true;

        $l_aConf = static::$_aConf;
        $l_aParam = static::$_aParameters;

        foreach ( $l_aConf[ 'parameters' ][ 'post' ] as $l_sParamName => $l_mParamValue ) {
            if ( !preg_match( $l_mParamValue[ 'regex' ], $l_aParam[ $l_sParamName ] ) ) {
                $l_bResult = false;
                static::$_aData[ 'errors' ][] = $l_sParamName . ' is incorrect';
            }
        }
        
        if ( $l_bResult ) {
            return static::SUCCESS;
        } else {
            return static::ERROR_PARAM_KO;
        }
    }

}
