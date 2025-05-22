<?php
require_once '../View/partials/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
  <h1>Create Account</h1>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form method="POST" action="register.php">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Register</button>
  </form>
</div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../Controller/UserController.php';
    $controller = new UserController();
    $controller->register(); 
}
?>
