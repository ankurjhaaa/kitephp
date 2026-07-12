<?php

namespace Kite\Core;

class Request
{
    public string $method;
    public string $uri;
    public array $query;
    public array $post;
    public array $files;
    public array $server;
    public array $headers;

    public static function capture(): self
    {
        $request = new self();
        $request->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $request->uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $request->query = $_GET;
        $request->post = $_POST;
        $request->files = $_FILES;
        $request->server = $_SERVER;
        
        $request->headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $request->headers[$header] = $value;
            }
        }

        // If it's a JSON request or PUT/PATCH, parse php://input
        if (in_array($request->method, ['PUT', 'PATCH', 'DELETE']) || strpos($request->header('Content-Type', ''), 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            if (is_array($data)) {
                $request->post = array_merge($request->post, $data);
            }
        }

        return $request;
    }

    public function header(string $name, $default = null)
    {
        return $this->headers[$name] ?? $default;
    }

    public function isAjax(): bool
    {
        return $this->header('X-Requested-With') === 'XMLHttpRequest' || $this->header('X-Kite-Request') === 'true';
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->query[$key] ?? $default;
    }
}
