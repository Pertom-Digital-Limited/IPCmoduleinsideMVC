<?php
// Show all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load config + core classes
require_once "app/config/config.php";
require_once "app/core/controller.php";
require_once "app/core/model.php";

// Check for both URL routing and query string parameters
if (isset($_GET['url'])) {
    // URL routing approach: /athlete/create
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $urlParts = explode('/', $url);
    
    $controllerName = $urlParts[0] ?? 'athlete';
    $action = $urlParts[1] ?? 'index';
} else {
    // Query string approach: ?controller=athlete&action=create
    $controllerName = isset($_GET['controller']) ? strtolower($_GET['controller']) : "athlete";
    $action = isset($_GET['action']) ? $_GET['action'] : "index";
}

// If no specific controller/action, use default routing
if (empty($controllerName)) {
    $controllerName = 'athlete';
    $action = 'index';
}

// Build controller class/file path
$controllerFile = "app/controllers/" . $controllerName . "controller.php";
$controllerClass = ucfirst($controllerName) . "Controller";

// Check if controller exists
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            // Call requested action
            $controller->$action();
        } else {
            http_response_code(404);
            echo "Action '$action' not found in $controllerClass.";
        }
    } else {
        http_response_code(404);
        echo "Controller class '$controllerClass' not found.";
    }
} else {
    http_response_code(404);
    echo "Controller '$controllerName' not found.";
}