<?php
require_once '../View/partials/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
  <h1>Login</h1>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php elseif (!empty($_SESSION['message'])): ?>
    <div class="message success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../Controller/UserController.php';
    $controller = new UserController();
    $controller->login(); 
}
?>
