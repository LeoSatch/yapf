<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define( '_CLASS_SUFFIXE', '.php' );


abstract class ParametersSettings {

    /**
     * tableau indexe comme ceci : [app][module][paramName] = array( 'name' => 'xxx', 'regex' => 'XXX' );
     *
     */
    public static $parametersValidation = array();

    public static function init( $in_sAppName ) {
        // load app conf
        require _APP_DIR . $in_sAppName . _APP_CONFIG_DIR . 'parameters.conf.php';
        self::$parametersValidation = $parameters;
    }

}
