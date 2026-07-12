<?php

namespace Kite\Core;

class ErrorHandler
{
    public static function register()
    {
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleError($level, $message, $file = '', $line = 0)
    {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public static function handleException(\Throwable $exception)
    {
        $code = $exception->getCode();
        
        // Map common codes to HTTP statuses, default to 500
        $httpCode = ($code >= 400 && $code < 600) ? $code : 500;
        
        http_response_code($httpCode);

        $request = Request::capture();

        if (Env::get('APP_DEBUG', false)) {
            if ($request->isAjax() && strpos($request->header('Accept'), 'application/json') !== false) {
                Response::json([
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ], $httpCode);
            } else {
                self::renderErrorPage($exception);
            }
        } else {
            // Production generic error
            $message = $httpCode == 404 ? 'Page Not Found' : 'An error occurred. Please try again later.';
            if ($request->isAjax()) {
                Response::json(['error' => $message], $httpCode);
            } else {
                echo "<h1 style='text-align:center;font-family:sans-serif;margin-top:50px;color:#333;'>{$httpCode} - {$message}</h1>";
            }
        }
    }

    public static function handleShutdown()
    {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
            self::handleException(new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
        }
    }

    protected static function renderErrorPage(\Throwable $exception)
    {
        // Extract lines around the error
        $file = $exception->getFile();
        $line = $exception->getLine();
        
        $lines = [];
        if (file_exists($file)) {
            $fileContent = file($file);
            $start = max(0, $line - 10);
            $end = min(count($fileContent) - 1, $line + 10);
            for ($i = $start; $i <= $end; $i++) {
                $lines[$i + 1] = rtrim($fileContent[$i]);
            }
        }
        
        // Render view
        try {
            $data = [
                'exception' => $exception,
                'class' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $file,
                'line' => $line,
                'trace' => $exception->getTraceAsString(),
                'traceArray' => $exception->getTrace(),
                'codeSnippet' => $lines
            ];
            
            // Render directly here to avoid circular errors if View class fails
            extract($data);
            
            $viewPath = dirname(__DIR__) . '/resource/view/system/error.php';
            if (file_exists($viewPath)) {
                require $viewPath;
            } else {
                echo "<h1>Fatal Error</h1><p>" . htmlspecialchars($exception->getMessage()) . "</p>";
            }
        } catch (\Throwable $e) {
            // Fallback if rendering fails
            echo "<h1>Fatal Error</h1><p>" . htmlspecialchars($exception->getMessage()) . "</p>";
        }
    }
}
