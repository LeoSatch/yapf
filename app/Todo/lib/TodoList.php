<?php

/**
 * Description of TodoList
 *
 * @author satch
 */

class TodoList extends TableAccess {

    protected $_sTasks = array();

    public  function __construct( $in_aData = array() ) {
        static $_sTableName = '';
    }

    public function load() {
        // load todo task from DB
        $sQuery = 'select * from todolist where user = 1';
        echo $sQuery;
        print_r( ParametersSettings::getBackends() );
    }

}
