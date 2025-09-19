<?php
session_start();
require_once "config.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Email ose fjalëkalimi gabim.';
        }
    } else {
        $error = 'Ploteso te dhënat.';
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title></head><body>
  <h2>Login</h2>
  <?php if ($error): ?><p style="color:red;"><?=htmlspecialchars($error)?></p><?php endif; ?>
  <form method="post">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
  </form>
  <p>Nuk ke llogari? <a href="register.php">Regjistrohu këtu</a></p>
  <p>Admin login? <a href="admin/login.php">Kliko këtu</a></p>
</body></html>
