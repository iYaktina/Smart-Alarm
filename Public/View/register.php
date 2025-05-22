<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include_once __DIR__ . '/partials/navbar.php'; ?>
<div class="container">
  <h1>Create Account</h1>
  <form method="POST" action="index.php?action=register">
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
