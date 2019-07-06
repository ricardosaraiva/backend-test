<?php 

use Firebase\JWT\JWT;
use Entity\UserEntity;
use Entity\UserLoginEntity;
use Controller\EventController;
use Controller\LoginController;
use Doctrine\ORM\EntityManager;

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

//enable cors
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app
->group('/', function () use ($app) {
    $app->post('event', EventController::class . ':addAction');
    $app->delete('event/{id}', EventController::class . ':cancelAction');
    $app->put('event/{id}', EventController::class . ':updateAction');
})
->add(new Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/", 
    "header" => "X-Token",
    "secret" => $container['jwtKey'],
    "callback" => function ($req, $res, $args) use ($container) {
        
        $em =  $container->get(EntityManager::class);

        $userLogin = $em
            ->getRepository(UserLoginEntity::class)
            ->findOneBy([
                'token' => $args['token']
            ]);

        if(empty($userLogin)) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }

        $user = $em->getRepository(UserEntity::class)->find($userLogin->getIdUser());

        if(empty($user)) {
            throw new  Exception('Invalid user');
        }

        $container['user'] = $user;
    }
]));


$app->post('/register', LoginController::class . ':registerAction');
$app->post('/login', LoginController::class . ':loginAction');
$app->get('/event[/{page}]', EventController::class . ':listAction');
$app->get('/event/{id}/detail', EventController::class . ':detailAction');