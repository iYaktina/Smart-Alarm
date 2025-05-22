<!-- View/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Alarms</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Welcome Back</h1>

    <?php if (!empty($_SESSION['message'])): ?>
      <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <h2>Your Alarms</h2>
    <?php if (empty($alarms)): ?>
      <p>No alarms yet. <a href="index.php?action=showForm">Set one now</a></p>
    <?php else: ?>
      <ul class="alarm-list">
        <?php foreach ($alarms as $alarm): ?>
          <li>
            <strong><?= htmlspecialchars($alarm['alarm_time']) ?></strong> —
            <?= htmlspecialchars($alarm['alarm_type']) ?> @ volume <?= $alarm['volume'] ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <a href="index.php?action=showForm" class="btn">+ Add Another</a>
    <?php endif; ?>
  </div>
</body>
</html>
