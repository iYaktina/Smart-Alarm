<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include_once __DIR__ . '/partials/navbar.php'; ?>
<div class="container">
  <h1>Login</h1>
  <form method="POST" action="index.php?action=login">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>
