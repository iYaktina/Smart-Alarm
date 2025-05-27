<?php
require_once '../Services/Observer/AlarmManager.php';
require_once '../Model/Alarm.php';

$mockTrafficData = [
    'origin' => '30.0626,31.2497',
    'destination' => '30.0330,31.2357',
    'normal_time_min' => 15,
    'traffic_time_min' => 25,
    'delay_minutes' => 10,     
    'status' => 'Delayed',
    'alarm_id' => 4,             
    'alarm_time' => '07:00:00'   
];

$alarmManager = new AlarmManager();

$alarmManager->update($mockTrafficData);

$alarmModel = new Alarm();
$updatedAlarm = $alarmModel->getById($mockTrafficData['alarm_id']);

if ($updatedAlarm) {
    echo "Alarm ID: {$updatedAlarm['id']}\n";
    echo "Original Time: {$mockTrafficData['alarm_time']}\n";
    echo "Updated Time: {$updatedAlarm['alarm_time']}\n";
} else {
    echo "No alarm found with ID {$mockTrafficData['alarm_id']}\n";
}
