<?php

/**
 * Description of User
 *
 * @author satch
 */


class User {

    protected $_aData = array();

    const DB_TABLE_NAME = 'user';
    const DB_DBNAME = 'yapf';

    public static function get( $in_sLogin, $in_sPass ) {
        $sQuery = "SELECT * FROM " . self::DB_TABLE_NAME . " WHERE login = :login AND password = :pass";

        $aRes = PDODB::queryOne( self::DB_DBNAME, $sQuery, array( ':login' => $in_sLogin, ':pass' => $in_sPass ) );
    }

}
