<?php
require_once '../Services/TrafficService.php';
require_once '../Services/Observer/AlarmManager.php';

$service = new TrafficService();
$observer = new AlarmManager(); 
$service->attach($observer);

$origin = 'Cairo University';
$destination = 'Tahrir Square';

$data = $service->fetchTraffic($origin, $destination);
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
    <h1>Traffic Status</h1>
    <?php if (isset($data['error'])): ?>
      <p class="message error"><?= $data['error'] ?></p>
    <?php else: ?>
      <ul>
        <li><strong>From:</strong> <?= $data['origin'] ?></li>
        <li><strong>To:</strong> <?= $data['destination'] ?></li>
        <li><strong>Normal Time:</strong> <?= $data['normal_time_min'] ?> mins</li>
        <li><strong>Traffic Time:</strong> <?= $data['traffic_time_min'] ?> mins</li>
        <li><strong>Delay:</strong> <?= $data['delay_minutes'] ?> mins</li>
        <li><strong>Status:</strong> <?= $data['status'] ?></li>
      </ul>
    <?php endif; ?>
  </div>
</body>
</html>
