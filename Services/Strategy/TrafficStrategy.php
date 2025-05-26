<?php
require_once 'WakeUpStrategy.php';

class TrafficStrategy implements WakeUpStrategy {
    private int $trafficDelayMinutes;

    public function __construct(int $trafficDelayMinutes) {
        $this->trafficDelayMinutes = $trafficDelayMinutes;
    }


    public function calculateWakeUpTime(string $alarmTime): string {
        $time = strtotime($alarmTime);
        $adjustedTime = strtotime("+{$this->trafficDelayMinutes} minutes", $time); 
        return date("H:i:s", $adjustedTime);
    }
}
