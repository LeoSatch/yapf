<?php

/**
 *
 */
class ToDoIndex extends Action {

    protected static $_oList;

    /**
     * 
     */
    public static function run( &$in_aConfiguration, &$out_aData = array(), &$in_aParameters = array() ) {
        // load all current todo list, done, in progress and to come
        static::$_oList = new TodoList();
        static::$_oList->load();
        $out_aData[ 'todoList' ] = static::$_oList->getData();

        return 'index';
    }

}
