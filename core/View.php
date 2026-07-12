<?php

namespace Kite\Core;

class View
{
    protected static string $layout = '';
    protected static array $sections = [];
    protected static string $currentSection = '';

    public static function make(string $view, array $data = [])
    {
        // Extract variables to be available in the view
        extract($data);

        // Path to the view
        $viewPath = dirname(__DIR__) . '/resource/view/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            abort(500, "View [{$view}] not found.");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (self::$layout !== '') {
            $layoutPath = dirname(__DIR__) . '/resource/view/' . str_replace('.', '/', self::$layout) . '.php';
            self::$layout = ''; // Reset layout for subsequent renders
            
            if (file_exists($layoutPath)) {
                ob_start();
                require $layoutPath;
                $content = ob_get_clean();
            }
        }

        // Output the content directly
        echo $content;
    }

    public static function layout(string $layout)
    {
        self::$layout = $layout;
    }

    public static function section(string $name)
    {
        self::$currentSection = $name;
        ob_start();
    }

    public static function endSection()
    {
        if (self::$currentSection === '') {
            return;
        }

        self::$sections[self::$currentSection] = ob_get_clean();
        self::$currentSection = '';
    }

    public static function yieldSection(string $name, string $default = '')
    {
        echo self::$sections[$name] ?? $default;
    }

    public static function component(string $view, array $data = [])
    {
        $viewPath = dirname(__DIR__) . '/resource/view/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            require $viewPath;
        }
    }
}
