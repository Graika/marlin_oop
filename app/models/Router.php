<?php

namespace CustClasses\models;

use DI\Container;
use FastRoute;
use DI\ContainerBuilder;
use CustClasses\models\QueryBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container as IlContainer;
use Illuminate\Events\Dispatcher;
use League\Plates\Engine;
use PDO;

class Router {
    private $contBuilder;

    public function __construct(ContainerBuilder $contBuilder) {
        $this->contBuilder = $contBuilder;
        $this->contBuilder->addDefinitions([
            Capsule::class => function() {
                $config = include "app/models/config.php";
                $config = $config['database_lara'];
                $capsule = new Capsule();
                $capsule->addConnection($config);
                $capsule->setEventDispatcher(new Dispatcher(new IlContainer));
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
                return $capsule;
            },

            PDO::class => function() {
                $config = include "app/models/config.php";
                $config = $config['database_pdo'];
                return new PDO("{$config['connection']};dbname={$config['database']};{$config['charset']};", $config['username'], $config['password']);
            },

            Engine::class => function() {
                return new Engine("app/templates/views");
            }
        ]);
        $this->run();
    }

    private function run() {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', ["CustClasses\controllers\UserController", 'users']);
            $r->addRoute('GET', '/logout', ["CustClasses\controllers\UserController", 'logout']);
            $r->addRoute(['GET', 'POST'], '/login', ["CustClasses\controllers\UserController", 'login']);
            $r->addRoute(['GET', 'POST'], '/reg', ["CustClasses\controllers\UserController", 'registration']);

            $r->addRoute(['GET', 'POST'], '/edit_profile', ["CustClasses\controllers\UserController", 'edit']);
            $r->addRoute(['GET', 'POST'], '/edit_profile/{id:\d+}', ["CustClasses\controllers\UserController", 'edit']);

            $r->addRoute(['GET', 'POST'], '/security', ["CustClasses\controllers\UserController", 'security']);
            $r->addRoute(['GET', 'POST'], '/security/{id:\d+}', ["CustClasses\controllers\UserController", 'security']);

            $r->addRoute(['GET', 'POST'], '/media', ["CustClasses\controllers\UserController", 'media']);
            $r->addRoute(['GET', 'POST'], '/media/{id:\d+}', ["CustClasses\controllers\UserController", 'media']);


            $r->addRoute(['GET', 'POST'], '/admin/create_user', ["CustClasses\controllers\AdminController", 'create_user']);
        });


// Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo 404;
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                break;
            case FastRoute\Dispatcher::FOUND:
                $cont = $this->contBuilder->build();
                $cont->call($routeInfo[1], ["vars" => $routeInfo[2]]);
                break;
        }
    }
}
