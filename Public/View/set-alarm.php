<?php
require_once '../../Include/auth.php';
require_once '../View/partials/navbar.php';
require_once '../../Commands/SetAlarmCommands.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $time = $_POST['alarm_time'];
    $type = $_POST['alarm_type'] ?? 'basic';
    $tone = $_POST['tone'] ?? 'default';
    $volume = (int)($_POST['volume'] ?? 5);

    $useTraffic = isset($_POST['use_traffic']) ? true : false;
    $trafficStart = $_POST['traffic_start'] ?? '';
    $trafficEnd = $_POST['traffic_end'] ?? '';

    $useWeather = isset($_POST['use_weather']) ? true : false;
    $tempMin = $_POST['temp_min'] ?? null;
    $tempMax = $_POST['temp_max'] ?? null;

    // Pass these new params to SetAlarmCommand (adjust class accordingly)
    $command = new SetAlarmCommand(
        $_SESSION['user_id'], $time, $type, $tone, $volume,
        $useTraffic, $trafficStart, $trafficEnd,
        $useWeather, $tempMin, $tempMax
    );

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
  <meta charset="UTF-8" />
  <title>Set Alarm</title>
  <link rel="stylesheet" href="../css/style.css" />
  <style>

  </style>
</head>
<body>
<div class="container">
  <h1>Set a New Alarm</h1>

  <form method="POST" action="">
    <label for="alarm_time">Alarm Time:</label>
    <input type="time" name="alarm_time" required />

    <label for="alarm_type">Type:</label>
    <select name="alarm_type" id="alarm_type" required>
      <option value="basic">Basic</option>
      <option value="smart">Smart (Weather + Traffic)</option>
    </select>

    <div id="smart-options" style="display:none; margin-top:15px;">
      <label>
        <input type="checkbox" name="use_traffic" id="use_traffic" />
        Use Traffic Data
      </label>
      <label>
        <input type="checkbox" name="use_weather" id="use_weather" />
        Use Weather Data
      </label>
    </div>

    <label for="tone">Tone:</label>
    <input type="text" name="tone" placeholder="e.g. sunrise.mp3" />

    <label for="volume">Volume (0–10):</label>
    <input type="number" name="volume" min="0" max="10" value="5" />

    <button type="submit">Save Alarm</button>
  </form>
</div>

<!-- Traffic Modal -->
<div class="modal" id="traffic-modal">
  <div class="modal-header">
    Traffic Locations
    <span class="modal-close" id="close-traffic">&times;</span>
  </div>
  <form id="traffic-form">
    <label for="traffic_start">Start Location:</label>
    <input type="text" id="traffic_start" name="traffic_start" placeholder="Enter start location" />

    <button type="button" id="use-device-location">Use My Location</button>

    <label for="traffic_end">End Location:</label>
    <input type="text" id="traffic_end" name="traffic_end" placeholder="Enter end location" />
  </form>
</div>

<!-- Weather Modal -->
<div class="modal" id="weather-modal">
  <div class="modal-header">
    Weather Settings
    <span class="modal-close" id="close-weather">&times;</span>
  </div>
  <form id="weather-form">
    <label for="temp_min">Wake Earlier If Temp Below (°C):</label>
    <input type="number" id="temp_min" name="temp_min" step="0.1" />

    <label for="temp_max">Wake Earlier If Temp Above (°C):</label>
    <input type="number" id="temp_max" name="temp_max" step="0.1" />
  </form>
</div>

<script src="../js/alarm-modal.js"></script>
</body>
</html>
