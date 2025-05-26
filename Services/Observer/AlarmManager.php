<?php
require_once 'Observer.php';
require_once '../../Model/Alarm.php'; 

class AlarmManager implements Observer {
    private Alarm $alarmModel;

    public function __construct() {
        $this->alarmModel = new Alarm();
    }

    public function update(array $data): void {
        if (isset($data['delay_minutes'])) {
            $this->adjustAlarmTimeForTraffic($data);
        }

        if (isset($data['status']) && ($data['status'] == 'cold' || $data['status'] == 'hot')) {
            $this->adjustAlarmTimeForWeather($data);
        }
    }

    private function adjustAlarmTimeForTraffic(array $data): void {
        $delay = $data['delay_minutes'];
        $newAlarmTime = date('H:i:s', strtotime('+' . $delay . ' minutes', strtotime($data['alarm_time'])));


        error_log("Updated alarm time due to traffic delay: " . $newAlarmTime);
    }

    private function adjustAlarmTimeForWeather(array $data): void {
        $newAlarmTime = date('H:i:s', strtotime('-10 minutes', strtotime($data['alarm_time'])));

        $this->alarmModel->updateAlarmTime($data['alarm_id'], $newAlarmTime);

        error_log("Updated alarm time due to weather conditions: " . $newAlarmTime);
    }
}
