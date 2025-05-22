<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>
<nav class="navbar">
  <div class="nav-container">
    <a href="index.php" class="nav-logo">SmartAlarm</a>
    <ul class="nav-menu">
      <?php if ($isLoggedIn): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="set-alarm.php">New Alarm</a></li>
        <?php if ($isAdmin): ?>
          <li><a href="admin.php">Admin Panel</a></li>
        <?php endif; ?>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
