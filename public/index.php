<?php

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response): Response {
    $response->getBody()->write('Hello, World from Slim!');
    return $response;
});

// Run the app and emit the response. This works both under web SAPI and CLI.
$app->run();
