<?php

/**
 * Description of Backend
 *
 * @author satch
 */
class Backend {

    protected static $_aBackends = array();

    /**
     * 
     * @param type $in_aAttributsList
     */
    public function get( $in_aAttributsList = array() ) {
        // check that all attributes are defined in conf
        // group them by db, table, pk
        foreach ( $in_aAttributsList as $sAttributeName ) {
            list( $sDB, $sTable, $sField ) = static::getFieldData( $sAttributeName );
        }
    }

    /**
     *
     * @param type $in_sAttributeName
     */
    public static function getFieldData( $in_sAttributeName ) {
        $aResults = array();
    }

    public static function getInstance( $name ) {
        // load conf
        print_r( ParametersSettings );
    }

}
