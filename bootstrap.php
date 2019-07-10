<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;

define('DIR_ROOT', __DIR__ . '/');

require DIR_ROOT . 'vendor/autoload.php';
require DIR_ROOT . 'config/app.php';

//if mode dev setting display error details
$config['slim']['settings']['displayErrorDetails'] = $config['app']['dev'];

$container = new \Slim\Container($config['slim']);

$container['config'] = function() use ($config) {
    return $config;
};

$container['jwtKey'] = 'kljrereoihlkjn,.mfnd879';
$container['dirPicuture'] = DIR_ROOT . 'public/pictures/';

$container[EntityManager::class] = function ($container) {
    $doctrineConfig = Setup::createAnnotationMetadataConfiguration(
        [$container->get('config')['app']['dirEntity']], 
        $container->get('config')['app']['dev']
    );
    
    $doctrineConfig->setMetadataDriverImpl(
        new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            new Doctrine\Common\Annotations\CachedReader(
                new Doctrine\Common\Annotations\AnnotationReader(),
                new Doctrine\Common\Cache\ArrayCache()
            ),
            $container->get('config')['app']['dirEntity']
        )
    );

    return  EntityManager::create($container->get('config')['db'], $doctrineConfig);
};
