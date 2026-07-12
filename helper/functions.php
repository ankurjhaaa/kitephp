<?php

use Kite\Core\Env;
use Kite\Core\Router;
use Kite\Core\View;
use Kite\Core\Request;
use Kite\Core\Response;
use Kite\Core\Session;
use Kite\Core\Database;

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('db')) {
    function db(string $table)
    {
        return Database::table($table);
    }
}

if (!function_exists('get')) {
    function get(string $uri, $action) { return Router::get($uri, $action); }
}
if (!function_exists('post')) {
    function post(string $uri, $action) { return Router::post($uri, $action); }
}
if (!function_exists('put')) {
    function put(string $uri, $action) { return Router::put($uri, $action); }
}
if (!function_exists('delete')) {
    function delete(string $uri, $action) { return Router::delete($uri, $action); }
}

if (!function_exists('view')) {
    function view(string $view, array $data = [])
    {
        return View::make($view, $data);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, int $status = 302)
    {
        return Response::redirect($url, $status);
    }
}

if (!function_exists('route')) {
    function route(string $name, array $parameters = [])
    {
        return Router::route($name, $parameters);
    }
}

if (!function_exists('url')) {
    function url(string $path = '')
    {
        $baseUrl = rtrim(env('APP_URL', 'http://localhost'), '/');
        return $baseUrl . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('asset')) {
    function asset(string $path)
    {
        return url($path);
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        // Simple config implementation to be expanded
        return $default;
    }
}

if (!function_exists('request')) {
    function request()
    {
        return Request::capture();
    }
}

if (!function_exists('session')) {
    function session(string $key = null, $default = null)
    {
        if ($key === null) {
            return Session::instance();
        }
        return Session::get($key, $default);
    }
}

if (!function_exists('cookie')) {
    function cookie(string $key, $default = null)
    {
        return $_COOKIE[$key] ?? $default;
    }
}

if (!function_exists('cache')) {
    function cache(string $key, $default = null)
    {
        // Simple cache stub
        return $default;
    }
}

if (!function_exists('json')) {
    function json($data, int $status = 200)
    {
        return Response::json($data, $status);
    }
}

if (!function_exists('abort')) {
    function abort(int $code, string $message = '')
    {
        throw new \Exception($message ?: "Error {$code}", $code);
    }
}

if (!function_exists('back')) {
    function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? url('/');
        return redirect($referer);
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        // Auth stub
        return null;
    }
}

if (!function_exists('user')) {
    function user()
    {
        // User stub
        return null;
    }
}

if (!function_exists('guest')) {
    function guest()
    {
        // Guest stub
        return true;
    }
}

if (!function_exists('csrf')) {
    function csrf()
    {
        $token = session('_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            session()->put('_token', $token);
        }
        return '<input type="hidden" name="_token" value="' . $token . '">';
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '')
    {
        return session()->getOldInput($key, $default);
    }
}

if (!function_exists('e')) {
    function e(string $value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if (!function_exists('seo')) {
    function seo(array $data)
    {
        $html = '';
        if (isset($data['title'])) {
            $html .= '<title>' . e($data['title']) . '</title>' . PHP_EOL;
            $html .= '<meta property="og:title" content="' . e($data['title']) . '">' . PHP_EOL;
            $html .= '<meta name="twitter:title" content="' . e($data['title']) . '">' . PHP_EOL;
        }
        if (isset($data['description'])) {
            $html .= '<meta name="description" content="' . e($data['description']) . '">' . PHP_EOL;
            $html .= '<meta property="og:description" content="' . e($data['description']) . '">' . PHP_EOL;
            $html .= '<meta name="twitter:description" content="' . e($data['description']) . '">' . PHP_EOL;
        }
        if (isset($data['canonical'])) {
            $html .= '<link rel="canonical" href="' . e($data['canonical']) . '">' . PHP_EOL;
            $html .= '<meta property="og:url" content="' . e($data['canonical']) . '">' . PHP_EOL;
        }
        return $html;
    }
}
