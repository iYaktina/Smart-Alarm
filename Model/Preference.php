<?php
require_once __DIR__ . '/../Include/db.inc.php';

class Preference {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function save(int $userId, bool $weatherSensitive, int $buffer, bool $gradualWake): bool {
        $stmt = $this->conn->prepare(
            "REPLACE INTO preferences (user_id, weather_sensitive, traffic_buffer, gradual_wake)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iibi", $userId, $weatherSensitive, $buffer, $gradualWake);
        return $stmt->execute();
    }

    public function get(int $userId): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM preferences WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
