<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/Logger.php';
require_once './controllers/UsuarioController.php';


// ELoquent
$container=$app->getContainer();

$capsule = new Capsule();
$capsule->addConnection([
 "driver" => "mysql",
 "host" => $_ENV['MYSQL_HOST'],
 "database" => $_ENV['MYSQL_DB'],
 "username" => $_ENV['MYSQL_USER'],
 "password" => $_ENV['MYSQL_PASS'],
 "charset" => "utf8",
 "collation" => "utf8_unicode_ci",
 "prefix" => ""
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();
//$app->setBasePath('/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('/{usuario}', \UsuarioController::class . ':CargarUno');
  })->add(\Logger::class . ':VerificadorCredenciales');


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Slim Framework 4 PHP");
    return $response;

});

$app->run();
