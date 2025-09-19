<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Panel</title></head>
<body>
  <h1>Admin Panel</h1>
  <p>Mirësevini, <?=htmlspecialchars($_SESSION['admin_name'])?> — <a href="logout.php">Logout</a></p>
  <ul>
    <li><a href="users.php">Menaxho Users</a></li>
    <li><a href="categories.php">Menaxho Categories</a></li>
    <li><a href="subcategories.php">Menaxho Subcategories</a></li>
    <li><a href="products.php">Menaxho Products</a></li>
    <li><a href="sales.php">Shikoni Sales</a></li>
  </ul>
</body>
</html>
