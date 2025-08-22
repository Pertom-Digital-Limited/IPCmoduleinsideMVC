<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Load config + core classes
require_once "app/config/config.php";
require_once "app/core/controller.php";
require_once "app/core/model.php";

// Get parameters from URL
$controllerName = isset($_GET['controller']) ? strtolower($_GET['controller']) : "athlete";
$action = isset($_GET['action']) ? $_GET['action'] : "index";

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
            die("Action '$action' not found in $controllerClass.");
        }
    } else {
        die("Controller class '$controllerClass' not found.");
    }
} else {
    die("Controller '$controllerName' not found.");
}
