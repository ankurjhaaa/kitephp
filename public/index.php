<?php

/**
 * KitePHP - Lightweight PHP Development Kit
 */

define('KITE_START', microtime(true));

// Handle static files for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if ($path && is_file($path)) {
        return false;
    }
}

// Load Autoloader
require __DIR__ . '/../core/Autoloader.php';

$autoloader = new \Kite\Core\Autoloader();
$autoloader->addNamespace('Kite\Core\\', __DIR__ . '/../core');
$autoloader->addNamespace('App\\Controller\\', __DIR__ . '/../app/controller');
$autoloader->addNamespace('App\\Middleware\\', __DIR__ . '/../app/middleware');
$autoloader->addNamespace('App\\Service\\', __DIR__ . '/../app/service');
$autoloader->addNamespace('App\\', __DIR__ . '/../app');
$autoloader->addNamespace('Database\\', __DIR__ . '/../database');
$autoloader->register();

// Load global helpers
require __DIR__ . '/../helper/functions.php';

// Initialize and run the application
$app = new \Kite\Core\App(dirname(__DIR__));
$app->run();
