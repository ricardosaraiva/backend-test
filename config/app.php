<?php


$config =  [
    'app' => [
        'dev' => false,
        'itemsPerPageDefault' => 10,
        'dirEntity' => DIR_ROOT . 'src/entity'
    ],
    'slim' => [],
    'db' => [
        'driver' => 'pdo_sqlite',
        'path' => DIR_ROOT . 'data/db.sqlite3',
    ]  
];
