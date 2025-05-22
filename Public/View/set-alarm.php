<?php
require_once '../Include/auth.php'; // requires login
require_once '../View/partials/navbar.php';
require_once '../Commands/SetAlarmCommand.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $time = $_POST['alarm_time'];
    $type = $_POST['alarm_type'] ?? 'basic';
    $tone = $_POST['tone'] ?? 'default';
    $volume = (int) ($_POST['volume'] ?? 5);

    $command = new SetAlarmCommand($_SESSION['user_id'], $time, $type, $tone, $volume);
    $_SESSION['message'] = $command->execute()
        ? "Alarm set successfully!"
        : "Failed to set alarm.";

    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set Alarm</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h1>Set a New Alarm</h1>
  <form method="POST" action="">
    <label for="alarm_time">Alarm Time:</label>
    <input type="time" name="alarm_time" required>

    <label for="alarm_type">Type:</label>
    <select name="alarm_type">
      <option value="basic">Basic</option>
      <option value="smart">Smart (Weather + Traffic)</option>
    </select>

    <label for="tone">Tone:</label>
    <input type="text" name="tone" placeholder="e.g. sunrise.mp3">

    <label for="volume">Volume (0–10):</label>
    <input type="number" name="volume" min="0" max="10" value="5">

    <button type="submit">Save Alarm</button>
  </form>
</div>
</body>
</html>
