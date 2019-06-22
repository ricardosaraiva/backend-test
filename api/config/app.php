<?php


$config =  [
    'app' => [
        'dev' => true,
        'dirEntity' => DIR_ROOT . 'src/entity'
    ],
    'slim' => [],
    'db' => [
        'driver' => 'pdo_sqlite',
        'path' => DIR_ROOT . 'data/db.sqlite3',
    ]  
];
