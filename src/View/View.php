<?php

namespace Bilbo\View;

class View
{
    public static function make($view, $params = [])
    {
        $baseContent = self::getBaseContent();
        $viewContent = self::getViewContent($view, params: $params);
        return (str_replace('{{content}}', $viewContent, $baseContent));
    }

    // Get Base Content
    protected static function getBaseContent()
    {
        ob_start(); // Make Buffering Content
        // Return Content
        include view_path() . 'layouts/main.php';
        return ob_get_clean(); // End Buffering
    }

    // Get View Content
    protected static function getViewContent($view, $isError = false, $params = [])
    {
        // View Path
        $path = $isError ? view_path() . 'errors/' : view_path();
        // Check View Path
        if (str_contains($view, '.')) {
            $views = explode('.', $view);
            foreach ($views as $view) {
                // If Dir -> Open Dir
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
            $view = $path . end($views) . '.php';
        } else {
            // Else Get File Content
            $view = $path . $view . '.php';
        }
        // Build Params
        extract($params);

        if ($isError) {
            // Include Error Page
            include $view;
        } else {
            // If NotError
            ob_start(); // Make Buffering Content
            include $view;
            return ob_get_clean(); // End Buffering
        }
    }

    public static function makeError($error)
    {
        self::getViewContent($error, true);
    }
}
