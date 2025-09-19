<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// Handle add user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('INSERT INTO users (name, email, role, created_at) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $role, time()]);
    }
    header('Location: users.php');
    exit;
}

// Handle edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    if ($id && $name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?');
        $stmt->execute([$name, $email, $role, $id]);
    }
    header('Location: users.php');
    exit;
}

// Handle delete user
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
    header('Location: users.php');
    exit;
}

$users = $pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Users</title></head><body>
<h2>Users</h2>
<p><a href="index.php"><< Back</a></p>
<table border="1" cellpadding="6" cellspacing="0">
<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created At</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
  <td><?=htmlspecialchars($u['id'])?></td>
  <td><?=htmlspecialchars($u['name'])?></td>
  <td><?=htmlspecialchars($u['email'])?></td>
  <td><?=htmlspecialchars($u['role'])?></td>
  <td><?=date('Y-m-d H:i:s', is_numeric($u['created_at']) ? $u['created_at'] : strtotime($u['created_at']))?></td>
  <td>
    <a href="users.php?edit=<?=urlencode($u['id'])?>">Edit</a> |
    <a href="users.php?delete=<?=urlencode($u['id'])?>" onclick="return confirm('A jeni i sigurt që doni ta fshini këtë user?')">Delete</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h3>Shto User</h3>
<form method="post">
  <input type="hidden" name="add_user" value="1">
  <label>Name: <input name="name" required></label><br>
  <label>Email: <input name="email" type="email" required></label><br>
  <label>Role: <input name="role" value="user"></label><br>
  <button type="submit">Shto</button>
</form>

<?php
// Edit form
if (isset($_GET['edit'])):
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $u = $stmt->fetch();
    if ($u):
?>
<hr>
<h3>Edit User #<?=htmlspecialchars($u['id'])?></h3>
<form method="post">
  <input type="hidden" name="edit_user" value="1">
  <input type="hidden" name="id" value="<?=htmlspecialchars($u['id'])?>">
  <label>Name: <input name="name" required value="<?=htmlspecialchars($u['name'])?>"></label><br>
  <label>Email: <input name="email" type="email" required value="<?=htmlspecialchars($u['email'])?>"></label><br>
  <label>Role: <input name="role" value="<?=htmlspecialchars($u['role'])?>"></label><br>
  <button type="submit">Save</button>
</form>
<?php
    endif;
endif;
?>
</body></html>
