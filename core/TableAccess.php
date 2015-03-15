<?php

/**
 * Description of TableAccess
 *
 * @author satch
 */
abstract class TableAccess {

    protected $_aMapping = array();
    protected $_aPK = array();
    protected $_aData = array();

    protected $_sTableName;
    protected $_sDBName;

    public function getData() {
        return $this->_aData;
    }

    public static function getAll() {
        $sQuery = 'SELECT * FROM ' . $this->_sTableName;

        DBConnexion::getInstance( self::$_sDBName )->query( $sQuery )->fetchAll();
    }

}
