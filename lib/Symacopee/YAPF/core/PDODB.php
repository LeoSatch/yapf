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
    
    /**
     * 
     * @param type $name
     * @return type
     */
    public static function getInstance( $name ) {
        if ( ! array_key_exists( $name, static::$_aDBPool )) {
            // create it by
            // getting conf
            if ( !array_key_exists($name, ParametersSettings::$backends)) {
                throw new Exception('cannot find backend ' . $name . ' in conf', 450 );
            }
            
            
            $aConf = ParametersSettings::$backends[ $name ];
            
            $sDSN = static::getDSN( $aConf );
            
            
        }
        
        return static::$_aDBPool[ $name ];
    }
    
    public static function getDSN( $aConf =  array()) {
        $toBeChecked = array( 'host', 'port', 'user', 'pass', 'name');
        foreach( $toBeChecked as $tmp ) {
            if ( ! array_key_exists( $tmp, $aConf )) {
                throw new RuntimeException('cannot find key ' . $tmp . ' in backend conf', 451);
            }
        }
        
        // return array( 'DSN' => );
    }
    
    /**
     * 
     * @param type $sQuery
     * @param type $aData
     */
    public static function exec( $sQuery, $aData = array()) {
        // prepare statement
        
        // execute
    }
    
    /**
     * 
     * @param type $sQuery
     * @param type $aData
     */
    public static function query( $sQuery, $aData = array() ) {
        
    }
}
