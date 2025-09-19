<?php
session_start();
require_once "config.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name && $email && $password) {
        // kontrollo nese email ekziston
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Ky email është i regjistruar tashmë!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$name, $email, $hash]);
            $user_id = $pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = 'user';
            header("Location: home.php");
            exit;
        }
    } else {
        $error = "Plotëso të gjitha fushat!";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
  <h2>Regjistrim</h2>
  <?php if ($error): ?><p style="color:red;"><?=htmlspecialchars($error)?></p><?php endif; ?>
  <form method="post">
    <label>Emri: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Regjistrohu</button>
  </form>
  <p>Ke tashmë llogari? <a href="login.php">Kyçu këtu</a></p>
</body>
</html>
