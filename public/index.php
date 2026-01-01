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

// Determine current language once per request
$currentLang = get_current_language();

// Route to change language and persist it in a cookie
$app->get('/set-lang/{lang}', function (Request $request, Response $response, array $args): Response {
    $supported = ['en', 'ru'];
    $default = 'en';

    $lang = $args['lang'] ?? $default;
    if (!in_array($lang, $supported, true)) {
        $lang = $default;
    }

    $params = $request->getQueryParams();
    $redirect = $params['redirect'] ?? APP_URL;

    $cookie = sprintf('lang=%s; Path=/; Max-Age=%d; HttpOnly=false', $lang, 365 * 24 * 60 * 60);
    $response = $response->withHeader('Set-Cookie', $cookie);

    return $response
        ->withHeader('Location', $redirect)
        ->withStatus(302);
});

// Home route ("/" and "/home")
$homeHandler = function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => '/'],
    ];

    return $renderer->render($response, 'layout.php', [
        'title' => __t('home.title'),
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'home.php',
    ]);
};
$app->get('/', $homeHandler);
$app->get('/home', $homeHandler);

// Part 1: What is a model in the mathematical sense
$app->get('/part-1/what-is-a-model', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.what_is_model'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/index.php',
    ]);
});
$app->get('/part-1/what-is-a-model/code-run', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.what_is_model'), 'url' => null],
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
