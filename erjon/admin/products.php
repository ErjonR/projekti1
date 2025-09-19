<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name'] ?? '');
    $subcategory_id = (int)($_POST['subcategory_id'] ?? 0);
    $price = is_numeric($_POST['price'] ?? null) ? $_POST['price'] : null;
    $stock = (int)($_POST['stock'] ?? 0);
    if ($name !== '' && $subcategory_id && $price !== null) {
        $stmt = $pdo->prepare('INSERT INTO products (subcategory_id, name, price, stock, created_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$subcategory_id, $name, $price, $stock, time()]);
    }
    header('Location: products.php');
    exit;
}

// Edit product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $subcategory_id = (int)($_POST['subcategory_id'] ?? 0);
    $price = is_numeric($_POST['price'] ?? null) ? $_POST['price'] : null;
    $stock = (int)($_POST['stock'] ?? 0);
    if ($id && $name !== '' && $subcategory_id && $price !== null) {
        $stmt = $pdo->prepare('UPDATE products SET subcategory_id = ?, name = ?, price = ?, stock = ? WHERE id = ?');
        $stmt->execute([$subcategory_id, $name, $price, $stock, $id]);
    }
    header('Location: products.php');
    exit;
}

// Delete product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
    }
    header('Location: products.php');
    exit;
}

$rows = $pdo->query('SELECT p.*, s.name as subcategory_name, c.name as category_name FROM products p LEFT JOIN subcategories s ON p.subcategory_id=s.id LEFT JOIN categories c ON s.category_id=c.id ORDER BY p.id DESC')->fetchAll();
$subs = $pdo->query('SELECT s.*, c.name as category_name FROM subcategories s LEFT JOIN categories c ON s.category_id=c.id ORDER BY c.name, s.name')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Products</title></head><body>
<h2>Products</h2>
<p><a href="index.php"><< Back</a></p>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Name</th><th>Category</th><th>Subcategory</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['id'])?></td>
  <td><?=htmlspecialchars($r['name'])?></td>
  <td><?=htmlspecialchars($r['category_name'])?></td>
  <td><?=htmlspecialchars($r['subcategory_name'])?></td>
  <td><?=htmlspecialchars($r['price'])?></td>
  <td><?=htmlspecialchars($r['stock'])?></td>
  <td><a href="products.php?edit=<?=urlencode($r['id'])?>">Edit</a> | <a href="products.php?delete=<?=urlencode($r['id'])?>" onclick="return confirm('Delete product?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Shto Product</h3>
<form method="post">
  <input type="hidden" name="add_product" value="1">
  <label>Subcategory:
    <select name="subcategory_id" required>
      <option value="">--zgjidh--</option>
      <?php foreach($subs as $s): ?>
      <option value="<?=htmlspecialchars($s['id'])?>"><?=htmlspecialchars($s['category_name'].' / '.$s['name'])?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Name: <input name="name" required></label><br>
  <label>Price: <input name="price" required></label><br>
  <label>Stock: <input name="stock" value="0" required></label><br>
  <button type="submit">Shto</button>
</form>

<?php if (isset($_GET['edit'])):
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    if ($p):
?>
<hr><h3>Edit Product</h3>
<form method="post">
  <input type="hidden" name="edit_product" value="1">
  <input type="hidden" name="id" value="<?=htmlspecialchars($p['id'])?>">
  <label>Subcategory:
    <select name="subcategory_id" required>
      <?php foreach($subs as $s): ?>
      <option value="<?=htmlspecialchars($s['id'])?>" <?= $s['id']==$p['subcategory_id'] ? 'selected' : '' ?>><?=htmlspecialchars($s['category_name'].' / '.$s['name'])?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Name: <input name="name" required value="<?=htmlspecialchars($p['name'])?>"></label><br>
  <label>Price: <input name="price" required value="<?=htmlspecialchars($p['price'])?>"></label><br>
  <label>Stock: <input name="stock" required value="<?=htmlspecialchars($p['stock'])?>"></label><br>
  <button type="submit">Save</button>
</form>
<?php endif; endif; ?>

</body></html>
