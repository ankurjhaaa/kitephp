<?php

namespace Kite\Core;

class Response
{
    public static function redirect(string $url, int $status = 302)
    {
        // If it's a Kite ajax request, we might want to send a header instead
        if (isset($_SERVER['HTTP_X_KITE_REQUEST']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('X-Kite-Redirect: ' . $url);
            http_response_code(200);
            exit;
        }

        header('Location: ' . $url, true, $status);
        exit;
    }

    public static function json($data, int $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
