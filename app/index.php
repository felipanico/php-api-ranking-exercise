<?php

require __DIR__ . '/vendor/autoload.php';

use function FastRoute\simpleDispatcher;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = simpleDispatcher(require __DIR__ . '/src/Routes/web.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
    case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $vars = $routeInfo[2];
        echo call_user_func_array([new $class, $method], $vars);
        break;
}
