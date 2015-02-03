<?php
$config = array(
    'authNeeded' => true,
    'parameters' => array(
        'post' => array(),
        'get'  => array(
            'id' => array(
                'type'  => 'int',
                'regex' => '/^\d+$/'
            )
        )
    )
);
