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
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="index.php?action=showForm">New Alarm</a></li>
        <li><a href="index.php?action=logout">Logout</a></li>
        <?php if ($isAdmin): ?>
          <li><a href="index.php?action=admin">Admin Panel</a></li>
        <?php endif; ?>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
