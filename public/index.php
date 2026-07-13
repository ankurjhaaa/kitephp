<?php

/**
 * KitePHP - The Full Stack PHP Micro-Framework
 * 
 * This is the entry point for all HTTP requests.
 * It loads the Composer autoloader and boots the application.
 */

define('KITE_START', microtime(true));

// Handle static files for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if ($path && is_file($path)) {
        return false;
    }
}

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Initialize and run the application
$app = new \Kite\Core\App(dirname(__DIR__));
$app->run();
