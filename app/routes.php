<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

// Determine current language once per request
$currentLang = get_current_language();

// Route to change language and persist it in a cookie
/** @var App $app */
$app->get('/set-lang/{lang}', function (Request $request, Response $response, array $args): Response {
    $supported = ['en', 'ru'];
    $default = 'en';

    $lang = $args['lang'] ?? $default;

    if (!in_array($lang, $supported, true)) {
        $lang = $default;
    }

    $params = $request->getQueryParams();
    $redirect = $params['redirect'] ?? APP_URL;

    // Validate redirect to prevent open redirects while still working
    // correctly when APP_URL is empty or does not contain a host
    // (e.g., when app is deployed under a subdirectory).
    if (!is_string($redirect) || $redirect === '') {
        $redirect = APP_URL ?: '/';
    } else {
        // Relative URL: always allow and keep it relative so that
        // frontends / reverse proxies can handle subdirectories.
        if (str_starts_with($redirect, '/')) {
            // leave $redirect as-is (relative to current host/base path)
        } else {
            $appUrlParts = parse_url(APP_URL);
            $redirectParts = parse_url($redirect);

            // If we cannot parse a host/scheme, or the scheme is not http/https,
            // treat as unsafe and fall back.
            $scheme = isset($redirectParts['scheme']) ? strtolower((string)$redirectParts['scheme']) : '';

            if (!$redirectParts || empty($redirectParts['host']) || !in_array($scheme, ['http', 'https'], true)) {
                $redirect = APP_URL ?: '/';
            } else {
                $redirectHost = strtolower($redirectParts['host']);

                // Build allow-list of hosts: APP_URL host (if present) and
                // current request host, so that prod behind a subdirectory
                // still works correctly.
                $allowedHosts = [];

                if (!empty($appUrlParts['host'])) {
                    $allowedHosts[] = strtolower((string)$appUrlParts['host']);
                }

                if (!empty($_SERVER['HTTP_HOST'])) {
                    $allowedHosts[] = strtolower((string)$_SERVER['HTTP_HOST']);
                }

                if ($allowedHosts && !in_array($redirectHost, $allowedHosts, true)) {
                    // Unsafe or external host: fall back
                    $redirect = APP_URL ?: '/';
                }
            }
        }
    }

    $maxAge = 31_536_000; // 365 * 24 * 60 * 60; - 1 year

    // Build cookie attributes: keep readable for JS, but add SameSite and Secure (when HTTPS)
    $cookieParts = [
        sprintf('lang=%s', $lang),
        'Path=/',
        sprintf('Max-Age=%d', $maxAge),
        'SameSite=Lax',
    ];

    // Add Secure flag when running over HTTPS
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $cookieParts[] = 'Secure';
    }

    $cookie = implode('; ', $cookieParts);
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

    return render_page($renderer, $response, $breadcrumbs, 'intro/home.php', [
        'title' => __t('home.heading'),
    ]);
};
$app->get('/', $homeHandler);
$app->get('/home', $homeHandler);

// ML Ecosystem in PHP page
$app->group('/ml-ecosystem-in-php', function ($app) use ($renderer): void {
    $app->get('', function (Request $request, Response $response) use ($renderer): Response {
        $breadcrumbs = [
            ['label' => __t('nav.home'), 'url' => APP_URL],
            ['label' => __t('ml_ecosystem.breadcrumb'), 'url' => null],
        ];

        return render_page($renderer, $response, $breadcrumbs, 'intro/ml-ecosystem-in-php/index.php', [
            'title' => __t('ml_ecosystem.title'),
        ]);
    });
    $app->get('/sample-in-php-ml', function (Request $request, Response $response) use ($renderer): Response {
        $breadcrumbs = [
            ['label' => __t('nav.home'), 'url' => APP_URL],
            ['label' => __t('ml_ecosystem.breadcrumb'), 'url' => APP_URL . 'ml-ecosystem-in-php'],
            ['label' => __t('ml_ecosystem.sample_phpml_title'), 'url' => null],
        ];

        return render_page($renderer, $response, $breadcrumbs, 'intro/ml-ecosystem-in-php/phpml-code-run.php', [
            'title' => __t('ml_ecosystem.sample_phpml_title'),
        ]);
    });
    $app->get('/sample-in-rubix-ml', function (Request $request, Response $response) use ($renderer): Response {
        $breadcrumbs = [
            ['label' => __t('nav.home'), 'url' => APP_URL],
            ['label' => __t('ml_ecosystem.breadcrumb'), 'url' => APP_URL . 'ml-ecosystem-in-php'],
            ['label' => __t('ml_ecosystem.sample_rubix_title'), 'url' => null],
        ];

        return render_page($renderer, $response, $breadcrumbs, 'intro/ml-ecosystem-in-php/rubix-code-run.php', [
            'title' => __t('ml_ecosystem.sample_rubix_title'),
        ]);
    });
});


// ---------------------------------------------------
// Part I:  What is a model in the mathematical sense
// ---------------------------------------------------
$app->group('/part-1', function ($app) use ($renderer): void {
    $app->group('/what-is-a-model', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/index.php');
        });
        $app->get('/function-as-the-model', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_function_as_the_model'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/function-as-the-model/index.php');
        });
        $app->get('/function-as-the-model/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_function_as_the_model'), 'url' => APP_URL . 'part-1/what-is-a-model/function-as-the-model'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/function-as-the-model/code-run.php');
        });
        $app->get('/error-as-measure-of-quality', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_error_as_measure_of_quality'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/error-as-measure-of-quality/index.php');
        });
        $app->get('/error-as-measure-of-quality/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_error_as_measure_of_quality'), 'url' => APP_URL . 'part-1/what-is-a-model/error-as-measure-of-quality'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/error-as-measure-of-quality/code-run.php');
        });
    });
});

// ---------------------------------------------------
// Part II. Learning as Optimization
// ---------------------------------------------------
$app->group('/part-2', function ($app) use ($renderer): void {
    $app->group('/errors-and-loss-functions', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/index.php');
        });
        $app->get('/case-1/mse-and-cost-of-a-big-miss', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case1_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/mse-and-cost-of-a-big-miss/index.php');
        });
        $app->get('/case-1/mse-and-cost-of-a-big-miss/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case1_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions/case-1/mse-and-cost-of-a-big-miss'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/mse-and-cost-of-a-big-miss/code-run.php');
        });
        $app->get('/case-2/model-selection-using-a-loss-function', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case2_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/model-selection-using-a-loss-function/index.php');
        });
        $app->get('/case-2/model-selection-using-a-loss-function/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions/case-2/model-selection-using-a-loss-function'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/model-selection-using-a-loss-function/code-run.php');
        });
        $app->get('/case-3/log-loss-and-classifier-confidence', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case3_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/log-loss-and-classifier-confidence/index.php');
        });
        $app->get('/case-3/log-loss-and-classifier-confidence/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case3_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions/case-3/log-loss-and-classifier-confidence'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/log-loss-and-classifier-confidence/code-run.php');
        });

    });
    $app->group('/linear-regression-as-basic-model', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/index.php');
        });
        $app->get('/case-1/apartment-valuation-based-on-parameters', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case1_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/apartment-valuation-based-on-parameters/index.php');
        });
        $app->get('/case-1/apartment-valuation-based-on-parameters/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case1_title'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/apartment-valuation-based-on-parameters/code-run.php');
        });
        $app->get('/case-1/apartment-valuation-based-on-parameters/rubix-code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case1_title'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/apartment-valuation-based-on-parameters/rubix-code-run.php');
        });
        $app->get('/case-2/developer-task-completion-time', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case2_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/developer-task-completion-time/index.php');
        });
        $app->get('/case-2/developer-task-completion-time/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case2_title'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model/case-2/developer-task-completion-time'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/developer-task-completion-time/code-run.php');
        });
        $app->get('/case-3/server-resource-consumption', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case3_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/server-resource-consumption/index.php');
        });
        $app->get('/case-3/server-resource-consumption/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case3_title'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model/case-3/server-resource-consumption'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/server-resource-consumption/code-run.php');
        });
    });
    $app->group('/gradient-descent-on-fingers', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/index.php');
        });
        $app->get('/implementation', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/implementation'],
                ['label' => __t('gradient_descent.implementation'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/implementation/index.php');
        });
        $app->get('/implementation/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/implementation'],
                ['label' => __t('gradient_descent.implementation'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/implementation'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/implementation/code-run.php');
        });
        $app->get('/implementation/vectors-code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/implementation'],
                ['label' => __t('gradient_descent.implementation'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/implementation'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/implementation/vectors-code-run.php');
        });
    });
});

// ---------------------------------------------------
// Part III. Classification and Probabilities
// ---------------------------------------------------
$app->group('/part-3', function ($app) use ($renderer): void {
    $app->group('/probability-as-degree-of-confidence', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/index.php');
        });
        $app->get('/implementation', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence/implementation'],
                ['label' => __t('nav.part3_softmax_example'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/implementation/index.php');
        });
        $app->get('/implementation/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence/implementation'],
                ['label' => __t('nav.part3_softmax_example'), 'url' => APP_URL . '/part-3/probability-as-degree-of-confidence/implementation'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/implementation/code-run.php');
        });
    });
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
