<?php

$configuration = array(
    'authNeeded' => false,
    'parameters' => array(
        'post' => array(
            'login'    => array(
                'type'  => 'string',
                'regex' => '/^.{8}$/'
            ),
            'password' => array(
                'type'  => 'string',
                'regex' => '/^.{8}$/'
            ),
        ),
        'get'  => array()
    )
);

