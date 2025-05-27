<?php
require_once '../../Include/auth.php';
require_once '../View/partials/navbar.php';
require_once '../../Model/Alarm.php';

$alarmModel = new Alarm();
$alarms = $alarmModel->getByUser($_SESSION['user_id']);

$nextAlarm = $alarmModel->getNextAlarmForUser($_SESSION['user_id']); 
$alarmTimeStr = $nextAlarm ? $nextAlarm['alarm_time'] : null;
$alarmTone = $nextAlarm ? $nextAlarm['tone'] : 'default.mp3';
?>

<script>
  window.alarmTimeStr = <?= json_encode($alarmTimeStr); ?>;
  window.alarmTone = <?= json_encode($alarmTone); ?>;
</script>
<script src="../js/dashboard.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
  <h1>Your Alarms</h1>

  <?php if (!empty($_SESSION['message'])): ?>
    <div class="message"><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <?php if (empty($alarms)): ?>
    <p>No alarms found. <a href="set-alarm.php" class="btn">Create One</a></p>
  <?php else: ?>
    <ul class="alarm-list">
      <?php foreach ($alarms as $alarm): ?>
        <li class="alarm-card">
          ⏰ <strong><?= htmlspecialchars($alarm['alarm_time']) ?></strong> 
          | <?= htmlspecialchars(ucfirst($alarm['alarm_type'])) ?> Alarm
          <br>
          🔊 Tone: <?= htmlspecialchars($alarm['tone']) ?> | Volume: <?= htmlspecialchars($alarm['volume']) ?>
          <br>
          <?php if ($alarm['use_traffic']): ?>
            <span class="tag traffic">🚗 Traffic Enabled</span>
          <?php endif; ?>
          <?php if ($alarm['use_weather']): ?>
            <span class="tag weather">🌤️ Weather Adjusted</span>
          <?php endif; ?>

          <form method="POST" action="delete-alarm.php" onsubmit="return confirm('Delete this alarm?');" style="margin-top: 10px;">
            <input type="hidden" name="alarm_id" value="<?= $alarm['id'] ?>">
            <button type="submit" class="btn danger">Delete</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="set-alarm.php" class="btn">+ Add Another Alarm</a>
  <?php endif; ?>
</div>

<div id="alarm-popup" style="display:none; position:fixed; top:30%; left:50%; transform:translateX(-50%); background:white; padding:20px; border:2px solid black; z-index:1000; width:300px; text-align:center;">
  <p>Alarm ringing!</p>
  <button id="snooze-btn">+5 minutes</button>
  <button id="stop-btn">Stop</button>
</div>
</body>
</html>
