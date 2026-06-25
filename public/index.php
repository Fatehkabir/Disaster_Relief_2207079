<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
// 1. Autoload dependencies and bootstrap the application instance
$app = require_once __DIR__.'/../bootstrap/app.php';

// 2. Run the application logic and process the captured request
$app->handle(
    Illuminate\Http\Request::capture()
);