<!-- View/alarm_form.php -->
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
    <form method="POST" action="index.php?action=setAlarm">
      <label for="alarm_time">Alarm Time:</label>
      <input type="time" id="alarm_time" name="alarm_time" required>

      <label for="alarm_type">Alarm Type:</label>
      <select name="alarm_type" id="alarm_type">
        <option value="basic">Basic</option>
        <option value="smart">Smart (Weather + Traffic)</option>
      </select>

      <label for="tone">Tone:</label>
      <input type="text" id="tone" name="tone" placeholder="e.g. sunrise.mp3">

      <label for="volume">Volume (0–10):</label>
      <input type="number" id="volume" name="volume" min="0" max="10" value="5">

      <button type="submit">Save Alarm</button>
      <a href="index.php">Back to Dashboard</a>
    </form>
  </div>
</body>
</html>
