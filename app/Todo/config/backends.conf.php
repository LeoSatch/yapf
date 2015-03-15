<?php

$backends = array(
    'mysql' => array(
        'host'     => CONST_DB_TODOLIST_HOST,
        'port'     => CONST_DB_TODOLIST_PORT,
        'username' => CONST_DB_TODOLIST_USER,
        'password' => CONST_DB_TODOLIST_PASS,
        'bases'    => array(
            'todolist' => array(
                'pk'     => array(),
                'fields' => array(
                    'title' => array(
                        'type'      => 'string',
                        'length'    => '50',
                        'validator' => '',
                    )
                )
            )
        ),
    )
);

