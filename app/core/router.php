<?php

class Router {
    private $routes = [];

    public function add($uri, $callback) {
        $this->routes[$uri] = $callback;
    }

    public function dispatch($uri) {
        if (isset($this->routes[$uri])) {
            $controllerAction = explode('@', $this->routes[$uri]);
            $controllerName = $controllerAction[0];
            $method = $controllerAction[1];

            $controller = new $controllerName();
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 - Route Not Found";
        }
    }
}
