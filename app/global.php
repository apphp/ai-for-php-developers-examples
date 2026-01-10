<?php

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
