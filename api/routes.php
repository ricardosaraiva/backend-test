<?php 

use Controller\EventController;

//setting error handle
$container['errorHandler'] = function ($container) {
    return function ($req, $res, $error) use ($container) {
        if($container->get('config')['app']['dev']) {
            return $res->withJson([
                'message' => $error->getMessage(),
                'trace' => $error->getTrace()
            ], 500);
        }

        return $res->withJson('Internal error', 500);
    };
};

$container['phpErrorHandler'] = function ($container) {
    return $container->get('errorHandler');
};

//setting error not found handler
$container['notFoundHandler'] = function ($container) {
    return function ($req, $res) use ($container) {
        return $res->withJson('Page not found', 404);
    };
};

$container['notAllowedHandler'] = function ($container) {
    return function ($req, $res) use ($container) {
        return $res->withJson('Method not allowed', 405);
    };
};


$app->get('/event[/{page}]', EventController::class . ':listAction');
$app->post('/event', EventController::class . ':addAction');