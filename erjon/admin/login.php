<?php
session_start();
require_once __DIR__ . '/../config.php';

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($email && $pass) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND role = ? LIMIT 1');
        $stmt->execute([$email, 'admin']);
        $user = $stmt->fetch();
        if ($user && isset($user['password']) && password_verify($pass, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            header('Location: index.php');
            exit;
        } else {
            $err = 'Credentialet nuk janë të sakta.';
        }
    } else {
        $err = 'Ploteso email dhe password.';
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title></head>
<body>
  <h2>Admin Login</h2>
  <?php if ($err): ?><p style="color:red;"><?=htmlspecialchars($err)?></p><?php endif; ?>
  <form method="post">
    <label>Email: <input name="email" type="email" required></label><br>
    <label>Password: <input name="password" type="password" required></label><br>
    <button type="submit">Hyr</button>
  </form>
  <p>Default admin: <strong>admin@example.com / admin123</strong> — ndrysho pas hyrjes.</p>
</body>
</html>
