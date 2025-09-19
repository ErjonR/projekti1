<?php
session_start();
require_once "config.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Home</title></head><body>
  <h1>Përshendetje, <?=htmlspecialchars($_SESSION['user_name'])?></h1>
  <p>Roli yt: <?=htmlspecialchars($_SESSION['user_role'])?></p>
  <?php if ($_SESSION['user_role'] === 'admin'): ?>
    <p><a href="admin/index.php">Shko në Admin Panel</a></p>
  <?php endif; ?>
  <p><a href="logout.php">Logout</a></p>
</body></html>
