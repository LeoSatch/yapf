<?php

/**
 * Description of Action
 *
 * @author satch
 */
abstract class Action {

    /**
     *
     * @var type 
     */
    protected static $_aConf = array();
    
    /**
     *
     * @var type 
     */
    protected static $_aParameters = array();
    
    /**
     *
     * @var type 
     */
    protected static $_aData = array();

    /**
     * 
     */
    const SUCCESS = 1001;
    
    /**
     * 
     */
    const ERROR_PARAM_KO = 2001;

    /**
     * 
     * @param type $in_aConfiguration
     * @param type $out_aData
     * @param type $in_aParameters
     * @return type
     */
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


    /**
     * 
     */
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
            $l_bResult = static::SUCCESS;
        } else {
            $l_bResult = static::ERROR_PARAM_KO;
        }
        
        return $l_bResult;
    }

}
