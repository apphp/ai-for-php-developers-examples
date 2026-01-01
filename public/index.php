<?php

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

$app = AppFactory::create();

$renderer = new PhpRenderer(__DIR__ . '/../views');

// Home route ("/" and "/home")
$homeHandler = function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => '/'],
    ];

    return $renderer->render($response, 'home.php', [
        'title' => 'Home',
        'message' => 'Hello, World from Slim Home view!',
        'breadcrumbs' => $breadcrumbs,
    ]);
};

$app->get('/', $homeHandler);
$app->get('/home', $homeHandler);

// Intro: Setting up environment route
$app->get('/intro/setting-up-environment', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Intro', 'url' => null],
        ['label' => 'Setting up environment', 'url' => null],
    ];

    return $renderer->render($response, 'intro-setting-up-environment.php', [
        'title' => 'Intro: Setting up environment',
        'message' => 'This is the Intro / Setting up environment page.',
        'breadcrumbs' => $breadcrumbs,
    ]);
});

// Run the app and emit the response. This works both under web SAPI and CLI.
$app->run();
