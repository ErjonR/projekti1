<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sub'])) {
    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    if ($name !== '' && $category_id) {
        $stmt = $pdo->prepare('INSERT INTO subcategories (category_id, name, created_at) VALUES (?, ?, ?)');
        $stmt->execute([$category_id, $name, time()]);
    }
    header('Location: subcategories.php');
    exit;
}

// Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_sub'])) {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    if ($id && $name !== '' && $category_id) {
        $stmt = $pdo->prepare('UPDATE subcategories SET name = ?, category_id = ? WHERE id = ?');
        $stmt->execute([$name, $category_id, $id]);
    }
    header('Location: subcategories.php');
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM subcategories WHERE id = ?');
        $stmt->execute([$id]);
    }
    header('Location: subcategories.php');
    exit;
}

$rows = $pdo->query('SELECT s.*, c.name as category_name FROM subcategories s LEFT JOIN categories c ON s.category_id=c.id ORDER BY s.id DESC')->fetchAll();
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Subcategories</title></head><body>
<h2>Subcategories</h2>
<p><a href="index.php"><< Back</a></p>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Name</th><th>Category</th><th>Created</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['id'])?></td>
  <td><?=htmlspecialchars($r['name'])?></td>
  <td><?=htmlspecialchars($r['category_name'])?></td>
  <td><?=date('Y-m-d H:i:s', $r['created_at'])?></td>
  <td><a href="subcategories.php?edit=<?=urlencode($r['id'])?>">Edit</a> | <a href="subcategories.php?delete=<?=urlencode($r['id'])?>" onclick="return confirm('Delete subcategory?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Shto Subcategory</h3>
<form method="post">
  <input type="hidden" name="add_sub" value="1">
  <label>Category:
    <select name="category_id" required>
      <option value="">--zgjidh--</option>
      <?php foreach($cats as $c): ?>
      <option value="<?=htmlspecialchars($c['id'])?>"><?=htmlspecialchars($c['name'])?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Name: <input name="name" required></label><br>
  <button type="submit">Shto</button>
</form>

<?php if (isset($_GET['edit'])):
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE id = ?');
    $stmt->execute([$id]);
    $s = $stmt->fetch();
    if ($s):
?>
<hr><h3>Edit Subcategory</h3>
<form method="post">
  <input type="hidden" name="edit_sub" value="1">
  <input type="hidden" name="id" value="<?=htmlspecialchars($s['id'])?>">
  <label>Category:
    <select name="category_id" required>
      <?php foreach($cats as $c): ?>
      <option value="<?=htmlspecialchars($c['id'])?>" <?= $c['id']==$s['category_id'] ? 'selected' : '' ?>><?=htmlspecialchars($c['name'])?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Name: <input name="name" required value="<?=htmlspecialchars($s['name'])?>"></label><br>
  <button type="submit">Save</button>
</form>
<?php endif; endif; ?>

</body></html>
