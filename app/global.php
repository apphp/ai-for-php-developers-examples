<?php

// Load environment variables from .env file
$envFile = __DIR__ . '/../.env';
if (is_file($envFile) && is_readable($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }

        $key = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));

        if ($key === '') {
            continue;
        }

        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        if (getenv($key) === false) {
            putenv($key . '=' . $value);
        }

        if (!isset($_ENV[$key])) {
            $_ENV[$key] = $value;
        }

        if (!isset($_SERVER[$key])) {
            $_SERVER[$key] = $value;
        }
    }
}

// Local
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('APP_MODE', 'local');
define('APP_URL', 'http://localhost:8088/');
define('APP_URL_DIR', '');
define('APP_ASSETS_URL', APP_URL);

// PROD
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
//define('APP_MODE', 'production');
//define('APP_URL', '');
//define("APP_URL_DIR", '');
//define('APP_ASSETS_URL', APP_URL . '/public/');
