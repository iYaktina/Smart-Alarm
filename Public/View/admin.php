<?php
require_once '../../Include/auth.php';
require_once '../../Model/User.php';
require_once '../View/partials/navbar.php';

if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: dashboard.php');
    exit;
}

$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'update') {
            $userModel->update(
                (int)$_POST['id'],
                $_POST['name'],
                $_POST['email'],
                isset($_POST['is_admin']) ? 1 : 0
            );
            $_SESSION['message'] = "User updated.";
        }

        if ($action === 'delete') {
            $userModel->delete((int)$_POST['id']);
            $_SESSION['message'] = "User deleted.";
        }

        if ($action === 'create') {
            $userModel->create(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                isset($_POST['is_admin']) ? 1 : 0
            );
            $_SESSION['message'] = "User created.";
        }

        header('Location: admin.php');
        exit;
    }
}

$users = $userModel->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
  <h1>Admin: Manage Users</h1>

  <?php if (!empty($_SESSION['message'])): ?>
    <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Admin</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <form method="POST">
          <td><?= htmlspecialchars($user['id']) ?></td>
          <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"></td>
          <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
          <td><input type="checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>></td>
          <td>
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <button type="submit" name="action" value="update">Update</button>
            <button type="submit" name="action" value="delete" onclick="return confirm('Delete user?')">Delete</button>
          </td>
        </form>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3 style="margin-top: 40px;">➕ Add New User</h3>
  <form method="POST" style="margin-top: 10px;">
    <input type="hidden" name="action" value="create">
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <label><input type="checkbox" name="is_admin"> Is Admin</label><br>
    <button type="submit">Create User</button>
  </form>
</div>
</body>
</html>
