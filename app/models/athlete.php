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
    try {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} 
            (givenName, familyName, dateOfBirth, sports_id, personalBestTime)
            VALUES (:givenName, :familyName, :dateOfBirth, :sports_id, :personalBestTime)
        ");

        $stmt->execute([
            ':givenName' => $data['givenName'],
            ':familyName' => $data['familyName'],
            ':dateOfBirth' => $data['dateOfBirth'],
            ':sports_id' => $data['sport_id'],   // notice we renamed this
            ':personalBestTime' => $data['personalBestTime'],
        ]);

    } catch (PDOException $e) {
        echo "Database insert error: " . $e->getMessage();
        exit;
    }
}
}


