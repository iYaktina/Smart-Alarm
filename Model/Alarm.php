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

}
?>
