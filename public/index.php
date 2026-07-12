<?php

/**
 * KitePHP - Lightweight PHP Development Kit
 */

define('KITE_START', microtime(true));

// Load Autoloader
require __DIR__ . '/../core/Autoloader.php';

$autoloader = new \Kite\Core\Autoloader();
$autoloader->addNamespace('Kite\Core\\', __DIR__ . '/../core');
$autoloader->addNamespace('App\\Controller\\', __DIR__ . '/../app/controller');
$autoloader->addNamespace('App\\Model\\', __DIR__ . '/../app/model');
$autoloader->addNamespace('App\\Middleware\\', __DIR__ . '/../app/middleware');
$autoloader->addNamespace('App\\Service\\', __DIR__ . '/../app/service');
$autoloader->addNamespace('App\\', __DIR__ . '/../app');
$autoloader->register();

// Load global helpers
require __DIR__ . '/../helper/functions.php';

// Initialize and run the application
$app = new \Kite\Core\App(dirname(__DIR__));
$app->run();
