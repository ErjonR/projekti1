<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cat'])) {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO categories (name, created_at) VALUES (?, ?)');
        $stmt->execute([$name, time()]);
    }
    header('Location: categories.php');
    exit;
}

// Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_cat'])) {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    if ($id && $name !== '') {
        $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->execute([$name, $id]);
    }
    header('Location: categories.php');
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id) {
        // Also optionally delete subcategories/products? For now just delete category.
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
    }
    header('Location: categories.php');
    exit;
}

$cats = $pdo->query('SELECT * FROM categories ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Categories</title></head><body>
<h2>Categories</h2>
<p><a href="index.php"><< Back</a></p>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Name</th><th>Created</th><th>Actions</th></tr>
<?php foreach($cats as $c): ?>
<tr>
  <td><?=htmlspecialchars($c['id'])?></td>
  <td><?=htmlspecialchars($c['name'])?></td>
  <td><?=date('Y-m-d H:i:s', $c['created_at'])?></td>
  <td><a href="categories.php?edit=<?=urlencode($c['id'])?>">Edit</a> | <a href="categories.php?delete=<?=urlencode($c['id'])?>" onclick="return confirm('Delete category?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Shto Kategori</h3>
<form method="post">
  <input type="hidden" name="add_cat" value="1">
  <label>Name: <input name="name" required></label>
  <button type="submit">Shto</button>
</form>

<?php if (isset($_GET['edit'])):
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    $c = $stmt->fetch();
    if ($c):
?>
<hr><h3>Edit Category</h3>
<form method="post">
  <input type="hidden" name="edit_cat" value="1">
  <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
  <label>Name: <input name="name" required value="<?=htmlspecialchars($c['name'])?>"></label>
  <button type="submit">Save</button>
</form>
<?php endif; endif; ?>

</body></html>
