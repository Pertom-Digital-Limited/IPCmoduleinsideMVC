<?php
require_once __DIR__ . '/../core/Model.php';

class Sport extends Model {
    private $table = 'sports';

    // Get all sports from DB
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}