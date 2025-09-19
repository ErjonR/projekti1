<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// Add sale
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sale'])) {
    $user_id = (int)($_POST['user_id'] ?? 0);
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 1);
    if ($user_id && $product_id && $quantity > 0) {
        // compute total from product price
        $stmt = $pdo->prepare('SELECT price, stock FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $p = $stmt->fetch();
        if ($p) {
            $total = $p['price'] * $quantity;
            $sale_date = time();
            $stmt = $pdo->prepare('INSERT INTO sales (user_id, product_id, quantity, total, sale_date) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$user_id, $product_id, $quantity, $total, $sale_date]);
            // reduce stock
            $newstock = max(0, $p['stock'] - $quantity);
            $stmt = $pdo->prepare('UPDATE products SET stock = ? WHERE id = ?');
            $stmt->execute([$newstock, $product_id]);
        }
    }
    header('Location: sales.php');
    exit;
}

// Edit sale
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_sale'])) {
    $id = (int)($_POST['id'] ?? 0);
    $user_id = (int)($_POST['user_id'] ?? 0);
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 1);
    if ($id && $user_id && $product_id && $quantity > 0) {
        // recalc total, and adjust stock difference
        $stmt = $pdo->prepare('SELECT product_id, quantity FROM sales WHERE id = ?');
        $stmt->execute([$id]);
        $old = $stmt->fetch();
        if ($old) {
            // restore old stock
            $stmt = $pdo->prepare('UPDATE products SET stock = stock + ? WHERE id = ?');
            $stmt->execute([$old['quantity'], $old['product_id']]);
        }
        $stmt = $pdo->prepare('SELECT price, stock FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $p = $stmt->fetch();
        if ($p) {
            $total = $p['price'] * $quantity;
            $stmt = $pdo->prepare('UPDATE sales SET user_id = ?, product_id = ?, quantity = ?, total = ?, sale_date = ? WHERE id = ?');
            $stmt->execute([$user_id, $product_id, $quantity, $total, time(), $id]);
            // reduce stock
            $stmt = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
            $stmt->execute([$quantity, $product_id]);
        }
    }
    header('Location: sales.php');
    exit;
}

// Delete sale
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id) {
        // restore stock
        $stmt = $pdo->prepare('SELECT product_id, quantity FROM sales WHERE id = ?');
        $stmt->execute([$id]);
        $r = $stmt->fetch();
        if ($r) {
            $stmt = $pdo->prepare('UPDATE products SET stock = stock + ? WHERE id = ?');
            $stmt->execute([$r['quantity'], $r['product_id']]);
        }
        $stmt = $pdo->prepare('DELETE FROM sales WHERE id = ?');
        $stmt->execute([$id]);
    }
    header('Location: sales.php');
    exit;
}

$rows = $pdo->query('SELECT s.*, u.name as user_name, p.name as product_name FROM sales s LEFT JOIN users u ON s.user_id=u.id LEFT JOIN products p ON s.product_id=p.id ORDER BY s.id DESC')->fetchAll();
$users = $pdo->query('SELECT id, name FROM users ORDER BY name')->fetchAll();
$products = $pdo->query('SELECT id, name, price FROM products ORDER BY name')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Sales</title></head><body>
<h2>Sales</h2>
<p><a href="index.php"><< Back</a></p>
<table border="1" cellpadding="6"><tr><th>ID</th><th>User</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['id'])?></td>
  <td><?=htmlspecialchars($r['user_name'])?></td>
  <td><?=htmlspecialchars($r['product_name'])?></td>
  <td><?=htmlspecialchars($r['quantity'])?></td>
  <td><?=htmlspecialchars($r['total'])?></td>
  <td><?=date('Y-m-d H:i:s', $r['sale_date'])?></td>
  <td><a href="sales.php?edit=<?=urlencode($r['id'])?>">Edit</a> | <a href="sales.php?delete=<?=urlencode($r['id'])?>" onclick="return confirm('Delete sale?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Shto Sale</h3>
<form method="post">
  <input type="hidden" name="add_sale" value="1">
  <label>User:
    <select name="user_id" required>
      <option value="">--zgjidh--</option>
      <?php foreach($users as $u): ?><option value="<?=htmlspecialchars($u['id'])?>"><?=htmlspecialchars($u['name'])?></option><?php endforeach; ?>
    </select>
  </label><br>
  <label>Product:
    <select name="product_id" required>
      <option value="">--zgjidh--</option>
      <?php foreach($products as $p): ?><option value="<?=htmlspecialchars($p['id'])?>"><?=htmlspecialchars($p['name'].' ('.$p['price'].')')?></option><?php endforeach; ?>
    </select>
  </label><br>
  <label>Quantity: <input name="quantity" type="number" value="1" min="1" required></label><br>
  <button type="submit">Shto</button>
</form>

<?php if (isset($_GET['edit'])):
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM sales WHERE id = ?');
    $stmt->execute([$id]);
    $s = $stmt->fetch();
    if ($s):
?>
<hr><h3>Edit Sale #<?=htmlspecialchars($s['id'])?></h3>
<form method="post">
  <input type="hidden" name="edit_sale" value="1">
  <input type="hidden" name="id" value="<?=htmlspecialchars($s['id'])?>">
  <label>User:
    <select name="user_id" required>
      <?php foreach($users as $u): ?><option value="<?=htmlspecialchars($u['id'])?>" <?= $u['id']==$s['user_id'] ? 'selected' : '' ?>><?=htmlspecialchars($u['name'])?></option><?php endforeach; ?>
    </select>
  </label><br>
  <label>Product:
    <select name="product_id" required>
      <?php foreach($products as $p): ?><option value="<?=htmlspecialchars($p['id'])?>" <?= $p['id']==$s['product_id'] ? 'selected' : '' ?>><?=htmlspecialchars($p['name'].' ('.$p['price'].')')?></option><?php endforeach; ?>
    </select>
  </label><br>
  <label>Quantity: <input name="quantity" type="number" value="<?=htmlspecialchars($s['quantity'])?>" min="1" required></label><br>
  <button type="submit">Save</button>
</form>
<?php endif; endif; ?>

</body></html>
