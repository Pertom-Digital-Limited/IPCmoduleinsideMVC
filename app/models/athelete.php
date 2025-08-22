<?php
require_once __DIR__ . '/../core/Model.php';

class Athlete extends Model {
    private $table = 'athletes';

    // Get all athletes
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new athlete into the database
    public function insert($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} 
            (givenName, familyName, dateOfBirth, sport, personalBestTime)
            VALUES (:givenName, :familyName, :dateOfBirth, :sport, :personalBestTime)
        ");
        $stmt->execute([
            ':givenName' => $data['givenName'],
            ':familyName' => $data['familyName'],
            ':dateOfBirth' => $data['dateOfBirth'],
            ':sport' => $data['sport'],
            ':personalBestTime' => $data['personalBestTime'],
        ]);
    }
}
