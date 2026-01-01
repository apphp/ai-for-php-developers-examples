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

    return $renderer->render($response, 'layout.php', [
        'title' => 'Home',
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'home.php',
        'message' => 'Hello, World from Slim Home view!',
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

    return $renderer->render($response, 'layout.php', [
        'title' => 'Intro: Setting up environment',
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'intro-setting-up-environment.php',
        'message' => 'This is the Intro / Setting up environment page.',
    ]);
});

// 404 handler: render standalone public/404.php (no layout)
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(
    \Slim\Exception\HttpNotFoundException::class,
    function (\Psr\Http\Message\ServerRequestInterface $request, \Throwable $exception, bool $displayErrorDetails): Response {
        $response = new \Slim\Psr7\Response(404);

        ob_start();
        include __DIR__ . '/../views/pages/404.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response->withStatus(404);
    }
);

// Run the app and emit the response. This works both under web SAPI and CLI.
$app->run();
