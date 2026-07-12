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

        $viewPath = self::resolvePath($view);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (self::$layout !== '') {
            $layoutPath = self::resolvePath(self::$layout);
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

    protected static function resolvePath(string $view): string
    {
        $base = dirname(__DIR__) . '/resource/view/' . str_replace('.', '/', $view);
        $kitePath = $base . '.kite.php';
        $phpPath = $base . '.php';

        // Check for .kite.php first
        if (file_exists($kitePath)) {
            return self::compile($kitePath);
        }

        // Fallback to raw .php
        if (file_exists($phpPath)) {
            return $phpPath;
        }

        abort(500, "View [{$view}] not found.");
    }

    protected static function compile(string $path): string
    {
        $cacheDir = dirname(__DIR__) . '/storage/cache/views';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        // Create a unique hash for the cached file
        $compiledPath = $cacheDir . '/' . md5($path) . '.php';

        // Recompile only if the view has been modified since the last compile
        if (!file_exists($compiledPath) || filemtime($path) > filemtime($compiledPath)) {
            $content = file_get_contents($path);
            
            // Compile {{ $var }} -> <?php echo e($var); ? >
            $content = preg_replace('/{{\s*(.+?)\s*}}/', '<?php echo e($1); ?>', $content);
            
            // Compile {!! $var !!} -> <?php echo $var; ? >
            $content = preg_replace('/{!!\s*(.+?)\s*!!}/', '<?php echo $1; ?>', $content);
            
            // Compile Control Structures
            $content = preg_replace('/@if\s*\((.*)\)/', '<?php if ($1): ?>', $content);
            $content = preg_replace('/@elseif\s*\((.*)\)/', '<?php elseif ($1): ?>', $content);
            $content = preg_replace('/@else/', '<?php else: ?>', $content);
            $content = preg_replace('/@endif/', '<?php endif; ?>', $content);
            
            $content = preg_replace('/@foreach\s*\((.*)\)/', '<?php foreach ($1): ?>', $content);
            $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);

            // Compile Layout Directives
            $content = preg_replace('/@extends\s*\((.*?)\)/', '<?php \Kite\Core\View::layout($1); ?>', $content);
            $content = preg_replace('/@section\s*\((.*?)\)/', '<?php \Kite\Core\View::section($1); ?>', $content);
            $content = preg_replace('/@endsection/', '<?php \Kite\Core\View::endSection(); ?>', $content);
            $content = preg_replace('/@yield\s*\((.*?)\)/', '<?php \Kite\Core\View::yieldSection($1); ?>', $content);
            
            // Compile simple helpers
            $content = preg_replace('/@csrf/', '<?php echo csrf(); ?>', $content);

            file_put_contents($compiledPath, $content);
        }

        return $compiledPath;
    }

    public static function layout(string $layout)
    {
        // Strip quotes if they were passed via @extends('layout')
        self::$layout = trim($layout, "'\"");
    }

    public static function section(string $name)
    {
        self::$currentSection = trim($name, "'\"");
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
        $name = trim($name, "'\"");
        echo self::$sections[$name] ?? $default;
    }

    public static function component(string $view, array $data = [])
    {
        $viewPath = self::resolvePath($view);
        extract($data);
        require $viewPath;
    }
}
