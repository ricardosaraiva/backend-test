<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/../bootstrap.php';

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($container[EntityManager::class])
);

