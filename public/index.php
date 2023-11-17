<?php

use App\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/', ['App\Controllers\ViewController', 'index']);
    $router->addRoute('GET', '/search?base={base}&to={compareTo}', ['App\Controllers\ViewController', 'search']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$pos = strpos($uri, '?');
if (false !== $pos && false === strpos($uri, 'search')) {
    $uri = substr($uri, 0, $pos);

}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found

        $loader = new FilesystemLoader('../app/views/');

        $twig = new Environment($loader);

        $problem = "invalid input";
        if (!$_GET["base"] || !$_GET["compareTo"]) {
            $problem = "Maybe forgot to fill out both search fields?";
        } elseif (strlen($_GET["base"]) > 4 || strlen($_GET["compareTo"]) > 4) {
            $problem = "Maybe used currency full names instead of codes? (exp. bitcoin instead of BTC)";
        }

        /**
         * @var Response $response
         */
        echo $twig->render('error.twig', ['errorCode' => 404, 'errorMessage' => 'Not Found', 'possibleIssue' => $problem]);
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];

        $loader = new FilesystemLoader('../app/views/');

        $twig = new Environment($loader);

        /**
         * @var Response $response
         */
        echo $twig->render('error.twig', ['errorCode' => 405, 'errorMessage' => 'Method Not allowed']);
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        if ($method != 'search') {
            $response = (new $controller)->{$method}();
        } else {
            $response = (new $controller)->{$method}($vars['base'], $vars['compareTo']);
        }
        $loader = new FilesystemLoader('../app/views/');

        $twig = new Environment($loader);

        /**
         * @var Response $response
         */
        echo $twig->render($response->getViewName() . '.twig', $response->getData());
        break;
}
