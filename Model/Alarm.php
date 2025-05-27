<?php
require_once __DIR__ . '/../Include/db.inc.php';

class Alarm {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create(
        int $userId,
        string $alarmTime,
        string $type = 'basic',
        string $tone = 'default',
        int $volume = 5,
        bool $useTraffic = false,
        ?string $trafficStart = null,
        ?string $trafficEnd = null,
        bool $useWeather = false,
        ?float $tempMin = null,
        ?float $tempMax = null
    ): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO alarms 
            (user_id, alarm_time, alarm_type, tone, volume, use_traffic, traffic_start, traffic_end, use_weather, temp_min, temp_max) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "isssiissidd",
            $userId, $alarmTime, $type, $tone, $volume,
            $useTraffic, $trafficStart, $trafficEnd,
            $useWeather, $tempMin, $tempMax
        );
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

    public function updateAlarmTime(int $alarmId, string $newTime): bool {
    $stmt = $this->conn->prepare("UPDATE alarms SET alarm_time = ? WHERE id = ?");
    $stmt->bind_param("si", $newTime, $alarmId);
    return $stmt->execute();
}

public function getLastInsertedId(): int {
    return $this->conn->insert_id;
}

public function delete(int $userId, int $alarmId): bool {
    $stmt = $this->conn->prepare("DELETE FROM alarms WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $alarmId, $userId);
    return $stmt->execute();
}

public function getById(int $id): ?array {
    $stmt = $this->conn->prepare("SELECT * FROM alarms WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}
public function getUserIdByAlarmId(int $alarmId): ?int {
    $stmt = $this->conn->prepare("SELECT user_id FROM alarms WHERE id = ?");
    $stmt->bind_param("i", $alarmId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        return (int)$row['user_id'];
    }

    return null; 
}

public function getNextAlarmForUser(int $userId): ?array {
    $stmt = $this->conn->prepare(
        "SELECT * FROM alarms WHERE user_id = ? AND alarm_time > NOW() ORDER BY alarm_time ASC LIMIT 1"
    );
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $alarm = $result->fetch_assoc();

    return $alarm ?: null;
}

}
?>
