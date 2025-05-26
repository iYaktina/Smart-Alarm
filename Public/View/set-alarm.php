<?php
require_once '../../Include/auth.php';
require_once '../../Include/config.php';
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
    $tempMin = isset($_POST['temp_min']) && $_POST['temp_min'] !== '' ? (float)$_POST['temp_min'] : null;
    $tempMax = isset($_POST['temp_max']) && $_POST['temp_max'] !== '' ? (float)$_POST['temp_max'] : null;

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
  <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo TRAFFIC_API_KEY; ?>&libraries=places" async defer></script>
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
    <input type="hidden" name="traffic_start" id="traffic_start">
    <input type="hidden" name="traffic_end" id="traffic_end">
    <input type="hidden" name="temp_min" id="temp_min">
    <input type="hidden" name="temp_max" id="temp_max">
    <button type="submit">Save Alarm</button>
  </form>
</div>
    
<div class="modal" id="traffic-modal">
  <div class="modal-header">
    Traffic Locations
    <span class="modal-close" id="close-traffic">&times;</span>
  </div>
  <form id="traffic-form">
    <label>Start Location:</label>
    <label>
      <input type="radio" name="start_location_option" value="use_device" id="use-device-location" />
      Use My Location
    </label>
    <label>
      <input type="radio" name="start_location_option" value="choose_on_map" id="choose-on-map" />
      Choose on Map
    </label>

    <label>End Location:</label>
    <button type="button" id="choose-end-location">
      <i class="fas fa-map-marker-alt"></i> Choose on Map
    </button>

    <input type="hidden" id="traffic_start_modal" name="traffic_start_modal" />
    <input type="hidden" id="traffic_end_modal" name="traffic_end_modal" />
        <button type="button" id="confirm-traffic" class="btn">Confirm</button>
  </form>
</div>


<div class="modal" id="weather-modal">
  <div class="modal-header">
    Weather Settings
    <span class="modal-close" id="close-weather">&times;</span>
  </div>
  <form id="weather-form">
    <label for="temp_min">Wake Earlier If Temp Below (°C):</label>
    <input type="number" id="temp_min_modal" name="temp_min_modal" step="0.1" />

    <label for="temp_max">Wake Earlier If Temp Above (°C):</label>
    <input type="number" id="temp_max_modal" name="temp_max_modal" step="0.1" />


       <button type="button" id="confirm-weather" class="btn">Confirm</button>
  </form>
</div>

<div class="modal" id="map-modal">
  <div class="modal-header">
    Choose Location
    <span class="modal-close" id="close-map">&times;</span>
  </div>
  <div id="map" style="width: 100%; height: 400px;"></div>
  <button type="button" id="confirm-location" style="margin-top: 10px;">Confirm Location</button>
</div>
<script src="../js/alarm-modal.js"></script>
</body>
</html>
