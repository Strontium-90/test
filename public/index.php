<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/bootstrap.php';


Debug::enable();
$request = Request::createFromGlobals();

$uri = ltrim($request->server->get('REQUEST_URI'), '/');

if (isset($routes[$uri])) {
    $route = $routes[$uri];

    $response = call_user_func([$controllers[$route['controller']], $route['method']], $request);
} else {
    $response = new Response('404 страница не найдена');
}
$response->send();
