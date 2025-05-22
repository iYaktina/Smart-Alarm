<?php
require_once '../Include/auth.php'; // requires login
require_once '../View/partials/navbar.php';
require_once '../Model/Alarm.php';

$alarmModel = new Alarm();
$alarms = $alarmModel->getByUser($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h1>Your Alarms</h1>

  <?php if (!empty($_SESSION['message'])): ?>
    <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <?php if (empty($alarms)): ?>
    <p>No alarms found. <a href="set-alarm.php" class="btn">Create One</a></p>
  <?php else: ?>
    <ul class="alarm-list">
      <?php foreach ($alarms as $alarm): ?>
        <li>
          ⏰ <?= htmlspecialchars($alarm['alarm_time']) ?> -
          <?= htmlspecialchars($alarm['alarm_type']) ?> Alarm
          <br>
          Tone: <?= $alarm['tone'] ?>, Volume: <?= $alarm['volume'] ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="set-alarm.php" class="btn">+ Add Another</a>
  <?php endif; ?>
</div>
</body>
</html>
