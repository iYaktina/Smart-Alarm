<?php
require_once 'WakeUpStrategy.php';

class TrafficStrategy implements WakeUpStrategy {
    public function calculateWakeUpTime(string $alarmTime): string {
        $time = strtotime($alarmTime);
        $adjustedTime = strtotime("-15 minutes", $time);
        return date("H:i:s", $adjustedTime);
    }
}
?>