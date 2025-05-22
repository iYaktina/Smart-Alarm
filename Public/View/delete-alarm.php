<?php
require_once '../../Include/auth.php';
require_once '../../Model/Alarm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alarm_id'])) {
    $alarmModel = new Alarm();
    $deleted = $alarmModel->delete($_SESSION['user_id'], $_POST['alarm_id']);
    $_SESSION['message'] = $deleted ? "Alarm deleted." : "Failed to delete alarm.";
}

header('Location: dashboard.php');
exit;
