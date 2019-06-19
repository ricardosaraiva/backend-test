<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

define('DIR_ROOT', __DIR__ . '/');

require DIR_ROOT . 'vendor/autoload.php';
require DIR_ROOT . 'config/app.php';

//if mode dev setting display error details
$config['slim']['settings']['displayErrorDetails'] = $config['app']['dev'];

$container = new \Slim\Container($config['slim']);

$container['config'] = function() use ($config) {
    return $config;
};

$container[EntityManager::class] = function ($container) {
    $doctrineConfig = Setup::createAnnotationMetadataConfiguration(DIR_ROOT . 'src/entity', $container->get('config')['dev']);
    return  EntityManager::create($container->get('config')['db'], $doctrineConfig);
};
