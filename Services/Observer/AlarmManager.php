<?php
require_once 'Observer.php';
require_once '../Model/Alarm.php'; 
require_once '../Model/Notificationn.php'; 

class AlarmManager implements Observer {
    private Alarm $alarmModel;
    private Notification $notificationModel;
    public function __construct() {
        $this->alarmModel = new Alarm();
    }

    public function update(array $data): void {
         
        if (isset($data['delay_minutes'])) {
            $this->adjustAlarmTimeForTraffic($data);
        }
      
    }

    private function adjustAlarmTimeForTraffic(array $data): void {
        $delay = $data['delay_minutes'];
        if ($delay > 0) {
    $newAlarmTime = date('H:i:s', strtotime('-' . $delay . ' minutes', strtotime($data['alarm_time'])));
    $this->alarmModel->updateAlarmTime($data['alarm_id'], $newAlarmTime);
    $message = "Your alarm time was adjusted earlier by {$delay} minutes due to traffic conditions.";
    $userId = $this->alarmModel->getUserIdByAlarmId($data['alarm_id']); // you need to add this method
        } 
        if ($userId) {
            $this->notificationModel->send($userId, $message,$data['alarm_id']);
        }
    }

    
}
