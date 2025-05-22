<?php
require_once 'WakeUpStrategy.php';

class WeatherStrategy implements WakeUpStrategy {
    public function calculateWakeUpTime(string $alarmTime): string {
        $time = strtotime($alarmTime);
        $adjustedTime = strtotime("-10 minutes", $time);
        return date("H:i:s", $adjustedTime);
    }
}
?>