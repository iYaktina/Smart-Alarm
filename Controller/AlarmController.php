<?php
require_once __DIR__ . '/../Model/Alarm.php';
require_once __DIR__ . '/../Commands/SetAlarmCommand.php';

class AlarmController {

    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        $alarmModel = new Alarm();
        $alarms = $alarmModel->getByUser($_SESSION['user_id']);

        require_once __DIR__ . '/../View/dashboard.php';
    }

    public function showForm() {
        require_once __DIR__ . '/../View/alarm_form.php';
    }
// ems7 line 20 

    public function setAlarm() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $time = $_POST['alarm_time'];
            $type = $_POST['alarm_type'] ?? 'basic';
            $tone = $_POST['tone'] ?? 'default';
            $volume = (int) ($_POST['volume'] ?? 5);

            $command = new SetAlarmCommand($_SESSION['user_id'], $time, $type, $tone, $volume);
            $success = $command->execute();

            if ($success) {
                $_SESSION['message'] = "Alarm set successfully!";
            } else {
                $_SESSION['message'] = "Failed to set alarm.";
            }
            header('Location: index.php');
        }
    }
}
