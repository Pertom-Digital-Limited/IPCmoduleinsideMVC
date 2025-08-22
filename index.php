<?php
// index.php - Front Controller

// Load routes
$routes = require __DIR__ . '/routes/web.php';

// Autoload Controllers and Models
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/controllers/' . $class . '.php',
        __DIR__ . '/app/models/' . $class . '.php',
        __DIR__ . '/app/core/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Get current request URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$request = '/' . trim(str_replace($scriptName, '', $requestUri), '/');

// Dispatch route
if (isset($routes[$request])) {
    $controllerAction = explode('@', $routes[$request]);
    $controllerName = $controllerAction[0];
    $method = $controllerAction[1];

    $controller = new $controllerName();
    $controller->$method();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
