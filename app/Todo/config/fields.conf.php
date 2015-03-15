<?php

$fields = array(
    'taskname' => array( 'dbField' => 'title', 'dbTable' => 'todo', 'dbName' => 'todolist', 'dbBackend' => 'mysql' ),
    'nom'      => array( 'dbField' => 'nom', 'dbTable' => 'utilisateur', 'dbName' => 'todolist', 'dbBackend' => 'mysql', 'needed' => array( 'prenom' ), 'postprocess' => 'createFullname' ),
);
