<?php
require_once __DIR__ . '/../Include/db.inc.php';

class Notification {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function send(int $userId, string $message, ?int $alarmId = null): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO notifications (user_id, alarm_id, message) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $userId, $alarmId, $message);
        return $stmt->execute();
    }

    public function getByUser(int $userId): array {
        $stmt = $this->conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY sent_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $list = [];
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        return $list;
    }
}
