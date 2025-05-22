<?php
interface WakeUpStrategy {
    public function calculateWakeUpTime(string $alarmTime): string;
}
?>