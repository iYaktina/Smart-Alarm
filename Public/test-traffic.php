<?php
require_once '../Services/TrafficService.php';
require_once '../Services/Observer/AlarmManager.php';
require_once '../Model/Alarm.php';

$service = new TrafficService();
$observer = new AlarmManager();
$service->attach($observer);

$origin = '30.0626,31.2497'; // Cairo Uni GPS coords
$destination = '30.0330,31.2357'; // Tahrir Square GPS coords

// Simulate an alarm ID in DB you want to update:
$alarmId = 4;
$alarmTime = '07:00:00';

// Fetch traffic and notify observers, which will update alarm time in DB
$data = $service->fetchTraffic($origin, $destination, $alarmTime, $alarmId);

// Fetch updated alarm from DB to confirm
$alarmModel = new Alarm();
$updatedAlarm = $alarmModel->getById($alarmId); // implement getById if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Traffic Test</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Traffic Status and Alarm Update</h1>

    <?php if (isset($data['error'])): ?>
      <p class="message error"><?= htmlspecialchars($data['error']) ?></p>
    <?php else: ?>
      <ul>
        <li><strong>From:</strong> <?= htmlspecialchars($data['origin']) ?></li>
        <li><strong>To:</strong> <?= htmlspecialchars($data['destination']) ?></li>
        <li><strong>Normal Time:</strong> <?= htmlspecialchars($data['normal_time_min']) ?> mins</li>
        <li><strong>Traffic Time:</strong> <?= htmlspecialchars($data['traffic_time_min']) ?> mins</li>
        <li><strong>Delay:</strong> <?= htmlspecialchars($data['delay_minutes']) ?> mins</li>
        <li><strong>Status:</strong> <?= htmlspecialchars($data['status']) ?></li>
      </ul>

      <?php if ($updatedAlarm): ?>
      <h2>Alarm After Traffic Update</h2>
      <ul>
        <li><strong>Alarm ID:</strong> <?= $updatedAlarm['id'] ?></li>
        <li><strong>Original Time:</strong> <?= $alarmTime ?></li>
        <li><strong>Updated Time:</strong> <?= htmlspecialchars($updatedAlarm['alarm_time']) ?></li>
      </ul>
      <?php else: ?>
        <p>No alarm found with ID <?= htmlspecialchars($alarmId) ?></p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
