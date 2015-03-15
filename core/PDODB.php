<?php

/**
 * Description of PDODB
 *
 * @author satch
 */
class PDODB {

    protected static $_aDBPool = array();

    public static function queryOne( $in_sDatabase, $in_sQuery, $in_aParameters ) {
        if ( !array_key_exists( $in_sDatabase, self::$_aDBPool ) ) {
            // on ajoute la connexion dans le pool
            $aConf = ParametersSettings::$db[ $in_sDatabase ];
            self::$_aDBPool[ $in_sDatabase ] = new PDO( 'mysql://127.0.0.1/test', 'root', '' );
        }
    }

}
