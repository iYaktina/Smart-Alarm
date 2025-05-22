<?php
require_once 'Observer.php';

class AlarmManager implements Observer {
    public function update(array $data): void {
        // Example: Adjust alarms or store updated weather/traffic info
        // In real implementation, you'd call Alarm model methods here
        // or recalculate alarm times.
        error_log("AlarmManager received update: " . json_encode($data));
    }
}
?>