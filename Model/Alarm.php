<?php
require_once __DIR__ . '/../Include/db.inc.php';

class Alarm {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create(int $userId, string $alarmTime, string $type = 'basic', string $tone = 'default', int $volume = 5): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO alarms (user_id, alarm_time, alarm_type, tone, volume) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssi", $userId, $alarmTime, $type, $tone, $volume);
        return $stmt->execute();
    }

    public function getByUser(int $userId): array {
        $stmt = $this->conn->prepare("SELECT * FROM alarms WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $alarms = [];
        while ($row = $result->fetch_assoc()) {
            $alarms[] = $row;
        }
        return $alarms;
    }
        public function delete(int $userId, int $alarmId): bool {
        $stmt = $this->conn->prepare("DELETE FROM alarms WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $alarmId, $userId);
        return $stmt->execute();
    }
}
