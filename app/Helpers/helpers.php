<?php

if (!function_exists('auth')) {
    /**
     * Returns the full Auth instance so its methods can be used globally.
     *
     * @return \App\Auth\Auth
     */
    function auth() {
        return \App\Auth\Auth::instance();
    }
}

if (!function_exists('gotolink')) {
    /**
     * Generate a URL based on a route name.
     * All routes will be funneled through the base path (e.g., "/masaree/public/index.php")
     * with a "goto" query parameter.
     *
     * @param string $name   The route name (e.g., "dashboard", "profile")
     * @param array  $params Optional parameters to be appended as a query string.
     * @return string
     */
    function gotolink($name, $params = []) {
        // Define the base URL for your site (adjust this if your public folder name changes)
        $base = '/masaree/public';
        $url = $base . '/index.php?goto=' . urlencode($name);
        if (!empty($params)) {
            $url .= '&' . http_build_query($params);
        }
        return $url;
    }
}

if (!function_exists('asset')) {
    /**
     * Returns the URL for an asset located in the public/assets folder.
     *
     * @param string $path The relative path to the asset (e.g., "css/style.css")
     * @return string
     */
    function asset($path) {
        return './assets/' . ltrim($path, '/');
    }
}

if (!function_exists('page')) {
    /**
     * Loads a view file from the app/pages folder and passes data to it.
     *
     * @param string $name The view file name (without the .php extension)
     * @param array  $data Associative array of data to be extracted into variables.
     * @return void
     */
    function page($name, $data = []) {
        // Since the helper file is in app/helpers, the pages folder is one level up in app/pages.
        $viewFile = dirname(__DIR__) . '/pages/' . $name . '.php';
        if (file_exists($viewFile)) {
            extract($data);
            include $viewFile;
        } else {
            echo "View '{$viewFile}' not found.";
        }
    }
}
if (!function_exists('admin_layout')) {
    /**
     * Loads the admin layout from the pages folder and passes the content and data.
     *
     * @param string $content The main content HTML to be injected into the layout.
     * @param array $data An associative array of additional data (optional).
     * @return void
     */
    function admin_layout($content, $data = [])
    {
        // Extract variables so they're available in the layout
        extract($data);
        // Build the full path to the admin layout file
        $layoutFile = dirname(__DIR__) . '/pages/layout/admin.php';
        if (file_exists($layoutFile)) {
            // Make $content available to the layout file
            include $layoutFile;
        } else {
            echo "Admin layout not found: " . $layoutFile;
        }
    }
}
if (!function_exists('user_layout')) {
    /**
     * Loads the user layout from the pages/layout directory.
     *
     * @param string $content The main content HTML.
     * @param array $data Additional data (e.g., title).
     */
    function user_layout($content, $data = [])
    {
        extract($data);
        $layoutFile = dirname(__DIR__) . '/pages/layout/user.php';
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            echo "User layout file not found: " . $layoutFile;
        }
    }
}