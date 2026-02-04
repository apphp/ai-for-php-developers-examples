<?php

require __DIR__ . '/../app/global.php';
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

$app = AppFactory::create();

if (APP_URL_DIR) {
    $app->setBasePath(APP_URL_DIR);
}

$renderer = new PhpRenderer(__DIR__ . '/../views');

// Register application routes and middleware
require __DIR__ . '/../app/routes.php';

// Run the app and emit the response. This works both under web SAPI and CLI.
$app->run();
