<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

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
    $app->get('/sample-in-transformers-php', function (Request $request, Response $response) use ($renderer): Response {
        $breadcrumbs = [
            ['label' => __t('nav.home'), 'url' => APP_URL],
            ['label' => __t('ml_ecosystem.breadcrumb'), 'url' => APP_URL . 'ml-ecosystem-in-php'],
            ['label' => __t('ml_ecosystem.sample_transformers_title'), 'url' => null],
        ];

        return render_page($renderer, $response, $breadcrumbs, 'intro/ml-ecosystem-in-php/transformers-code-run.php', [
            'title' => __t('ml_ecosystem.sample_transformers_title'),
        ]);
    });
    $app->get('/sample-in-llphant', function (Request $request, Response $response) use ($renderer): Response {
        $breadcrumbs = [
            ['label' => __t('nav.home'), 'url' => APP_URL],
            ['label' => __t('ml_ecosystem.breadcrumb'), 'url' => APP_URL . 'ml-ecosystem-in-php'],
            ['label' => __t('ml_ecosystem.sample_llphant_title'), 'url' => null],
        ];

        return render_page($renderer, $response, $breadcrumbs, 'intro/ml-ecosystem-in-php/llphant-code-run.php', [
            'title' => __t('ml_ecosystem.sample_llphant_title'),
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
        $app->get('/learning-as-minimization-of-error', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_learning_as_min_error'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/learning-as-minimization-of-error/index.php');
        });
        $app->get('/learning-as-minimization-of-error/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_what_is_model'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_learning_as_min_error'), 'url' => APP_URL . 'part-1/what-is-a-model/learning-as-minimization-of-error'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/what-is-a-model/learning-as-minimization-of-error/code-run.php');
        });
    });
    $app->group('/vectors-dimensions-and-feature-spaces', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_vectors'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/vectors-dimensions-and-feature-spaces/index.php');
        });
        $app->get('/vector-dimension', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_vectors'), 'url' => APP_URL . 'part-1/vectors-dimensions-and-feature-spaces'],
                ['label' => __t('vectors_feature_spaces.links.vector_dimension'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/vectors-dimensions-and-feature-spaces/vector-dimension/index.php');
        });
        $app->get('/vector-dimension/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part1_title'), 'url' => APP_URL . 'part-1/what-is-a-model'],
                ['label' => __t('nav.part1_vectors'), 'url' => APP_URL . 'part-1/vectors-dimensions-and-feature-spaces'],
                ['label' => __t('vectors_feature_spaces.links.vector_dimension'), 'url' => APP_URL . 'part-1/vectors-dimensions-and-feature-spaces/vector-dimension'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-1/vectors-dimensions-and-feature-spaces/vector-dimension/code-run.php');
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
        $app->get('/case-4/same-accuracy-different-log-loss', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case4_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/same-accuracy-different-log-loss/index.php');
        });
        $app->get('/case-4/same-accuracy-different-log-loss/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('nav.part2_error_loss_functions'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('errors_loss.case4_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions/case-4/same-accuracy-different-log-loss'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/errors-and-loss-functions/same-accuracy-different-log-loss/code-run.php');
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
        $app->get('/case-4/customer-check-valuation', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case4_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/customer-check-valuation/index.php');
        });
        $app->get('/case-4/customer-check-valuation/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('linear_regression.heading'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model'],
                ['label' => __t('linear_regression.case4_title'), 'url' => APP_URL . 'part-2/linear-regression-as-basic-model/case-4/customer-check-valuation'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/linear-regression-as-basic-model/customer-check-valuation/code-run.php');
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
        $app->get('/sample-1/parameter-trajectory', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers'],
                ['label' => __t('gradient_descent.sample1_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory/index.php');
        });
        $app->get('/sample-1/parameter-trajectory/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part2_title'), 'url' => APP_URL . 'part-2/errors-and-loss-functions'],
                ['label' => __t('gradient_descent.heading'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers'],
                ['label' => __t('gradient_descent.sample1_title'), 'url' => APP_URL . 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory/code-run.php');
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
        $app->get('/case-1/spam-filter-probability-vs-decision', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('probability_confidence.case1_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/spam-filter-probability-vs-decision/index.php');
        });
        $app->get('/case-1/spam-filter-probability-vs-decision/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('probability_confidence.case1_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence/case-1/spam-filter-probability-vs-decision'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/spam-filter-probability-vs-decision/code-run.php');
        });
        $app->get('/case-2/medical-test-updating-confidence', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('probability_confidence.case2_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/medical-test-updating-confidence/index.php');
        });
        $app->get('/case-2/medical-test-updating-confidence/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_probability_confidence'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('probability_confidence.case2_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence/case-2/medical-test-updating-confidence'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/probability-as-degree-of-confidence/medical-test-updating-confidence/code-run.php');
        });
    });
    $app->group('/logistic-regression', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/index.php');
        });
        $app->get('/case-1/client-churn', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => APP_URL . 'part-3/logistic-regression'],
                ['label' => __t('logistic_regression.case1_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/client-churn/index.php');
        });
        $app->get('/case-1/client-churn/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => APP_URL . 'part-3/logistic-regression'],
                ['label' => __t('logistic_regression.case1_title'), 'url' => APP_URL . 'part-3/logistic-regression/case-1/client-churn'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/client-churn/code-run.php');
        });
        $app->get('/case-1/client-churn/rubix-code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => APP_URL . 'part-3/logistic-regression'],
                ['label' => __t('logistic_regression.case1_title'), 'url' => APP_URL . 'part-3/logistic-regression/case-1/client-churn'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/client-churn/rubix-code-run.php');
        });
        $app->get('/case-2/newsletter-subscription', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => APP_URL . 'part-3/logistic-regression'],
                ['label' => __t('logistic_regression.case2_title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/newsletter-subscription/index.php');
        });
        $app->get('/case-2/newsletter-subscription/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('nav.part3_logistic_regression'), 'url' => APP_URL . 'part-3/logistic-regression'],
                ['label' => __t('logistic_regression.case2_title'), 'url' => APP_URL . 'part-3/logistic-regression/case-2/newsletter-subscription'],
                ['label' => __t('nav.code_run'), null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/logistic-regression/newsletter-subscription/code-run.php');
        });
    });
    $app->group('/why-naive-bayes-works', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/index.php');
        });
        $app->get('/case-1/categorical-features-and-frequencies', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case1.title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/categorical-features-and-frequencies/index.php');
        });
        $app->get('/case-1/categorical-features-and-frequencies/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case1.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/categorical-features-and-frequencies/code-run.php');
        });
        $app->get('/case-1/categorical-features-and-frequencies/rubix-code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case1.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/categorical-features-and-frequencies/rubix-code-run.php');
        });
        $app->get('/case-2/spam-filter-on-words-bernoulli-naive-bayes', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case2.title'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/spam-filter-on-words-bernoulli-naive-bayes/index.php');
        });
        $app->get('/case-2/spam-filter-on-words-bernoulli-naive-bayes/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case2.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works/case-2/spam-filter-on-words-bernoulli-naive-bayes'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/spam-filter-on-words-bernoulli-naive-bayes/code-run.php');
        });
        $app->get('/case-2/spam-filter-on-words-bernoulli-naive-bayes/rubix-code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part3_title'), 'url' => APP_URL . 'part-3/probability-as-degree-of-confidence'],
                ['label' => __t('why_naive_bayes_works.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works'],
                ['label' => __t('why_naive_bayes_works.case2.title'), 'url' => APP_URL . 'part-3/why-naive-bayes-works/case-2/spam-filter-on-words-bernoulli-naive-bayes'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-3/why-naive-bayes-works/spam-filter-on-words-bernoulli-naive-bayes/rubix-code-run.php');
        });
    });
});

// ---------------------------------------------------
// Part IV. Proximity and data structure
// ---------------------------------------------------
$app->group('/part-4', function ($app) use ($renderer): void {
    $app->group('/k-nearest-neighbors-algorithm-and-local-solutions', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_knn_local_solutions'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/index.php');
        });
        $app->get('/case-1/client-classification-by-behavior', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_knn_local_solutions'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('knn_local_solutions.index.case1'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/client-classification-by-behavior/index.php');
        });
        $app->get('/case-1/client-classification-by-behavior/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_knn_local_solutions'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('knn_local_solutions.index.case1'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/case-1/client-classification-by-behavior'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/client-classification-by-behavior/code-run.php');
        });
        $app->get('/case-2/apartment-price-estimation', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_knn_local_solutions'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('knn_local_solutions.index.case2'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/apartment-price-estimation/index.php');
        });
        $app->get('/case-2/apartment-price-estimation/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_knn_local_solutions'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('knn_local_solutions.index.case2'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/case-2/apartment-price-estimation'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/apartment-price-estimation/code-run.php');
        });
    });
    $app->group('/decision-trees-and-space-partitioning', function ($app) use ($renderer): void {
        $app->get('', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/k-nearest-neighbors-algorithm-and-local-solutions'],
                ['label' => __t('nav.part4_decision_trees_space_partitioning'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/decision-trees-and-space-partitioning/index.php');
        });
        $app->get('/case-1/tutorial-decision-tree', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('nav.part4_decision_trees_space_partitioning'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('decision_trees_space_partitioning.index.case1'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/decision-trees-and-space-partitioning/tutorial-decision-tree/index.php');
        });
        $app->get('/case-1/tutorial-decision-tree/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('nav.part4_decision_trees_space_partitioning'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('decision_trees_space_partitioning.index.case1'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning/case-1/tutorial-decision-tree'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/decision-trees-and-space-partitioning/tutorial-decision-tree/code-run.php');
        });
        $app->get('/case-2/classification-with-rubixml', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('nav.part4_decision_trees_space_partitioning'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('decision_trees_space_partitioning.index.case2'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/decision-trees-and-space-partitioning/classification-with-rubixml/index.php');
        });
        $app->get('/case-2/classification-with-rubixml/code-run', function (Request $request, Response $response) use ($renderer): Response {
            $breadcrumbs = [
                ['label' => __t('nav.home'), 'url' => APP_URL],
                ['label' => __t('nav.part4_title'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('nav.part4_decision_trees_space_partitioning'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning'],
                ['label' => __t('decision_trees_space_partitioning.index.case2'), 'url' => APP_URL . 'part-4/decision-trees-and-space-partitioning/case-2/classification-with-rubixml'],
                ['label' => __t('nav.code_run'), 'url' => null],
            ];

            return render_page($renderer, $response, $breadcrumbs, 'part-4/decision-trees-and-space-partitioning/classification-with-rubixml/code-run.php');
        });
    });
});

 // ---------------------------------------------------
 // Part V. Text as mathematics
 // ---------------------------------------------------
 $app->group('/part-5', function ($app) use ($renderer): void {
     $app->group('/why-do-words-turn-into-numbers', function ($app) use ($renderer): void {
         $app->get('', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_why_do_words_turn_into_numbers'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/why-do-words-turn-into-numbers/index.php');
         });
     });
     $app->group('/bag-of-words-and-tf-idf', function ($app) use ($renderer): void {
         $app->get('', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_bag_of_words_and_tf_idf'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/bag-of-words-and-tf-idf/index.php');
         });

         $app->get('/simple-tf-idf-example', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_bag_of_words_and_tf_idf'), 'url' => APP_URL . 'part-5/bag-of-words-and-tf-idf'],
                 ['label' => __t('bag_of_words_and_tf_idf.simple_tfidf_example'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/bag-of-words-and-tf-idf/simple-tf-idf-example/index.php');
         });
         $app->get('/simple-tf-idf-example/code-run', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_bag_of_words_and_tf_idf'), 'url' => APP_URL . 'part-5/bag-of-words-and-tf-idf'],
                 ['label' => __t('bag_of_words_and_tf_idf.simple_tfidf_example'), 'url' => APP_URL . 'part-5/bag-of-words-and-tf-idf/simple-tf-idf-example'],
                 ['label' => __t('nav.code_run'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/bag-of-words-and-tf-idf/simple-tf-idf-example/code-run.php');
         });
     });
     $app->group('/hands-on-embedding-in-php-with-transformers', function ($app) use ($renderer): void {
         $app->get('', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_hands_on_embedding_in_php_with_transformers'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/hands-on-embedding-in-php-with-transformers/index.php');
         });
         $app->get('/case-4/intelligent-timelines', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_hands_on_embedding_in_php_with_transformers'), 'url' => APP_URL . 'part-5/hands-on-embedding-in-php-with-transformers'],
                 ['label' => __t('hands_on_embedding_in_php_with_transformers.index.case4'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/hands-on-embedding-in-php-with-transformers/intelligent-timelines/index.php');
         });
         $app->get('/case-4/intelligent-timelines/code-run', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_hands_on_embedding_in_php_with_transformers'), 'url' => APP_URL . 'part-5/hands-on-embedding-in-php-with-transformers'],
                 ['label' => __t('hands_on_embedding_in_php_with_transformers.index.case4'), 'url' => APP_URL . 'part-5/hands-on-embedding-in-php-with-transformers/case-4/intelligent-timelines'],
                 ['label' => __t('nav.code_run'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/hands-on-embedding-in-php-with-transformers/intelligent-timelines/code-run.php');
         });
     });
     $app->group('/retrieval-augmented-generation-as-engineering-system', function ($app) use ($renderer): void {
         $app->get('', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/index.php');
         });
         $app->get('/why-do-words-turn-into-numbers', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item1'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/why-do-words-turn-into-numbers/index.php');
         });
         $app->get('/bag-of-words-and-tf-idf', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item2'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/bag-of-words-and-tf-idf/index.php');
         });
         $app->get('/embeddings-as-continuous-spaces-of-meaning', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item3'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/embeddings-as-continuous-spaces-of-meaning/index.php');
         });
         $app->get('/transformers-and-context', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item4'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/transformers-and-context/index.php');
         });
         $app->get('/hands-on-embeddings-in-php-with-transformers', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item5'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/hands-on-embeddings-in-php-with-transformers/index.php');
         });
         $app->get('/rag-as-engineering-system', function (Request $request, Response $response) use ($renderer): Response {
             $breadcrumbs = [
                 ['label' => __t('nav.home'), 'url' => APP_URL],
                 ['label' => __t('nav.part5_title'), 'url' => APP_URL . 'part-5/why-do-words-turn-into-numbers'],
                 ['label' => __t('nav.part5_retrieval_augmented_generation_as_engineering_system'), 'url' => APP_URL . 'part-5/retrieval-augmented-generation-as-engineering-system'],
                 ['label' => __t('rag_engineering_system.index.item6'), 'url' => null],
             ];

             return render_page($renderer, $response, $breadcrumbs, 'part-5/retrieval-augmented-generation-as-engineering-system/rag-as-engineering-system/index.php');
         });
     });
 });



/* ****** */

// 404 handler: render standalone 404 page (no layout)
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(
    HttpNotFoundException::class,
    function (\Psr\Http\Message\ServerRequestInterface $request, \Throwable $exception, bool $displayErrorDetails): Response {
        $response = new \Slim\Psr7\Response(404);

        ob_start();
        include __DIR__ . '/../views/pages/404.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);

        return $response->withStatus(404);
    }
);
