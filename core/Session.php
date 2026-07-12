<?php

namespace Kite\Core;

class Session
{
    protected static ?self $instance = null;

    protected function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configure session path if needed
            $savePath = dirname(__DIR__) . '/storage/session';
            if (is_dir($savePath)) {
                session_save_path($savePath);
            }
            session_start();
        }
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function get(string $key, $default = null)
    {
        self::instance();
        return $_SESSION[$key] ?? $default;
    }

    public function put(string $key, $value): void
    {
        self::instance();
        $_SESSION[$key] = $value;
    }

    public function flash(string $key, $value): void
    {
        self::instance();
        $_SESSION['_flash'][$key] = $value;
    }

    public function getOldInput(string $key, $default = '')
    {
        self::instance();
        return $_SESSION['_old_input'][$key] ?? $default;
    }
}
