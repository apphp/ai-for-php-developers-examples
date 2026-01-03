<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Determine current language once per request
$currentLang = get_current_language();

// Route to change language and persist it in a cookie
/** @var Slim\App $app */
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
/** @var Slim\Views\PhpRenderer $renderer */
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

// ---------------------------------------------------
// Part 1:
// ---------------------------------------------------
// What is a model in the mathematical sense
$app->get('/part-1/what-is-a-model', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_what_is_model'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/index.php',
    ]);
});
$app->get('/part-1/what-is-a-model/function-as-the-model', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_function_as_the_model'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/function-as-the-model/index.php',
    ]);
});
$app->get('/part-1/what-is-a-model/function-as-the-model/code-run', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_function_as_the_model'), 'url' => APP_URL . 'part-1/what-is-a-model/function-as-the-model'],
        ['label' => __t('nav.code_run'), null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/function-as-the-model/code-run.php',
    ]);
});
$app->get('/part-1/what-is-a-model/error-as-measure-of-quality', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_error_as_measure_of_quality'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/error-as-measure-of-quality/index.php',
    ]);
});
$app->get('/part-1/what-is-a-model/error-as-measure-of-quality/code-run', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
        ['label' => __t('nav.part1_error_as_measure_of_quality'), 'url' => APP_URL . 'part-1/what-is-a-model/error-as-measure-of-quality'],
        ['label' => __t('nav.code_run'), null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'what-is-a-model/error-as-measure-of-quality/code-run.php',
    ]);
});

// ---------------------------------------------------
// Part 2:
// ---------------------------------------------------
$app->get('/part-2/errors-and-loss-functions', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
        ['label' => __t('nav.part2_error_loss_functions'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'errors-and-loss-functions/index.php',
    ]);
});
$app->get('/part-2/errors-and-loss-functions/case-1/mse-and-cost-of-a-big-miss', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
        ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
        ['label' => __t('errors_loss.case1_title'), 'url' => null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'errors-and-loss-functions/mse-and-cost-of-a-big-miss/index.php',
    ]);
});
$app->get('/part-2/errors-and-loss-functions/case-1/mse-and-cost-of-a-big-miss/code-run', function (Request $request, Response $response) use ($renderer): Response {
    $breadcrumbs = [
        ['label' => __t('nav.home'), 'url' => APP_URL],
        ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
        ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
        ['label' => __t('errors_loss.case1_title'), 'url' => null],
        ['label' => __t('nav.code_run'), null],
    ];

    return $renderer->render($response, 'layout.php', [
        'breadcrumbs' => $breadcrumbs,
        'contentTemplate' => 'errors-and-loss-functions/mse-and-cost-of-a-big-miss/code-run.php',
    ]);
});

// 404 handler: render standalone 404 page (no layout)
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
