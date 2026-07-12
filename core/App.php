<?php

namespace Kite\Core;

/**
 * The main application wrapper for KitePHP.
 * Handles the initialization of the application and routing of the request.
 */
class App
{
    /**
     * The absolute path to the root directory.
     */
    protected string $basePath;

    /**
     * App constructor.
     *
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->bootstrap();
    }

    /**
     * Bootstraps the application.
     */
    protected function bootstrap(): void
    {
        // Load environment variables
        Env::load($this->basePath . '/.env');

        // Register custom professional error handler
        if (class_exists(ErrorHandler::class)) {
            ErrorHandler::register();
        }

        // Setup error handling based on env (fallback behavior for core PHP errors if needed)
        $debug = Env::get('APP_DEBUG', false);
        if ($debug) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            error_reporting(0);
        }

        // Load route definitions
        $this->loadRoutes();
    }

    /**
     * Load the application's route files.
     */
    protected function loadRoutes(): void
    {
        $webRoutePath = $this->basePath . '/route/url.php';
        if (file_exists($webRoutePath)) {
            require $webRoutePath;
        }

        $apiRoutePath = $this->basePath . '/route/api.php';
        if (file_exists($apiRoutePath)) {
            require $apiRoutePath;
        }
    }

    /**
     * Run the application, dispatch the request and send the response.
     */
    public function run(): void
    {
        // Handle Request and Route matching
        $request = Request::capture();
        $response = Router::dispatch($request);
        $response->send();
    }
}
