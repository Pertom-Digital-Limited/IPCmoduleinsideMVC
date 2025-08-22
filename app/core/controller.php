<?php

class Controller {
    // Load a view
    public function view($view, $data = []) {
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            extract($data); // Make $data keys available as variables
            require $viewFile;
        } else {
            echo "View $view not found";
        }
    }
}
