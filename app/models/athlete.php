<?php
require_once __DIR__ . '/../core/Model.php';

class Athlete extends Model {
    private $table = 'athletes';

    // Get all athletes with sport name
    public function getAll() {
    $stmt = $this->pdo->query("
        SELECT a.*, s.name as sport 
        FROM {$this->table} a 
        LEFT JOIN sports s ON a.sport_id = s.id 
        ORDER BY a.id DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Insert new athlete
    public function insert(array $data) {
    try {
        $sql = "
            INSERT INTO {$this->table}
            (givenName, familyName, dateOfBirth, sport_id, personalBestTime, created_by)
            VALUES (
                :givenName,
                :familyName,
                :dateOfBirth,
                :sport_id,
                :personalBestTime,
                NULL
            )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':givenName'        => $data['givenName'],
            ':familyName'       => $data['familyName'],
            ':dateOfBirth'      => $data['dateOfBirth'],
            ':sport_id'         => (int)$data['sport_id'],
            ':personalBestTime' => $data['personalBestTime'],
        ]);

        return $this->pdo->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Database insert error: " . $e->getMessage());
    }
}
}