<?php

namespace Kite\Core;

class Router
{
    protected static array $routes = [];
    protected static array $namedRoutes = [];
    protected static string $currentGroupPrefix = '';
    protected static array $currentGroupMiddleware = [];

    public static function get(string $uri, $action)
    {
        return self::addRoute('GET', $uri, $action);
    }

    public static function post(string $uri, $action)
    {
        return self::addRoute('POST', $uri, $action);
    }
    
    public static function put(string $uri, $action)
    {
        return self::addRoute('PUT', $uri, $action);
    }
    
    public static function delete(string $uri, $action)
    {
        return self::addRoute('DELETE', $uri, $action);
    }

    protected static function addRoute(string $method, string $uri, $action)
    {
        $uri = self::$currentGroupPrefix . $uri;
        $uri = $uri === '/' ? $uri : rtrim($uri, '/');

        $route = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => self::$currentGroupMiddleware
        ];

        self::$routes[] = $route;
        
        $routeIndex = count(self::$routes) - 1;

        return new class($routeIndex) {
            private int $index;
            public function __construct(int $index) { $this->index = $index; }
            public function name(string $name) {
                Router::nameRoute($this->index, $name);
                return $this;
            }
        };
    }

    public static function nameRoute(int $index, string $name)
    {
        if (isset(self::$routes[$index])) {
            self::$routes[$index]['name'] = $name;
            self::$namedRoutes[$name] = self::$routes[$index]['uri'];
        }
    }

    public static function route(string $name, array $parameters = [])
    {
        if (!isset(self::$namedRoutes[$name])) {
            return '';
        }

        $uri = self::$namedRoutes[$name];
        foreach ($parameters as $key => $value) {
            $uri = str_replace('{' . $key . '}', $value, $uri);
        }

        return url($uri);
    }

    public static function dispatch(Request $request)
    {
        $uri = rtrim($request->uri, '/');
        if ($uri === '') $uri = '/';

        foreach (self::$routes as $route) {
            if ($route['method'] !== $request->method && $route['method'] !== 'ANY') {
                continue;
            }

            // Convert Route URI to Regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_.-]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Route matched
                $parameters = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $parameters[$key] = $value;
                    }
                }

                $response = self::execute($route['action'], $parameters, $request);
                
                if ($response instanceof Response) {
                    return $response;
                }
                
                // Return a dummy response if it already echoed (View does this for now)
                return new class {
                    public function send() {}
                };
            }
        }

        // 404
        abort(404, 'Page not found');
    }

    protected static function execute($action, array $parameters, Request $request)
    {
        array_unshift($parameters, $request);

        if (is_callable($action)) {
            return call_user_func_array($action, array_values($parameters));
        }

        if (is_string($action)) {
            list($controller, $method) = explode('@', $action);
            $controllerClass = "App\\Controller\\" . $controller;
            
            if (class_exists($controllerClass)) {
                $instance = new $controllerClass();
                return call_user_func_array([$instance, $method], array_values($parameters));
            }
        }
        
        abort(500, 'Route action not found');
    }
}
