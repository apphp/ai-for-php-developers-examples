<?php

require __DIR__ . '/../app/global.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/functions.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

$app = AppFactory::create();
if (APP_URL_DIR) {
    $app->setBasePath(APP_URL_DIR);
}

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

// Part 1: What is a model in the mathematical sense
$app->get('/part-1/what-is-a-model', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => APP_URL],
        ['label' => 'Part I. The Mathematical Language of AI', 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => 'What is a model', 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/index.php',
    ]);
});
$app->get('/part-1/what-is-a-model/code-run', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => APP_URL],
        ['label' => 'Part I. The Mathematical Language of AI', 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => 'What is a model', 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/code-run.php',
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
