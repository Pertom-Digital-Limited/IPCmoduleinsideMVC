<?php
require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    private $table = 'users';

    // Basic user methods if needed
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}