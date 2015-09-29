<?php


class AuthenticatorIndex extends Action {

    /**
     * garde la page appelée en session et lance l'authentification
     * @param array $in_aConfiguration
     * @param array $out_aData
     * @param array $in_aParameters
     * @return string
     */
    public static function run( & $in_aConfiguration, & $out_aData = array(), & $in_aParameters = array() ) {
        //
        session_start();

        // on garde trace de la page demandee
        $_SESSION[ 'URL' ] = $_SERVER[ 'REQUEST_URI' ];

        // on retourne l'index
        return 'index';
    }

}
