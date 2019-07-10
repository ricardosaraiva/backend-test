<?php 

require __DIR__ . '/../bootstrap.php';

$app = new \Slim\App($container);

require DIR_ROOT . 'routes.php';

$app->run();