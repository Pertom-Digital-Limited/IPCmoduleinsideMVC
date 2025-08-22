<?php

class Model {
    protected $pdo;

    public function __construct() {
        $config = require __DIR__ . '/../config/config.php';
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                $config['username'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
