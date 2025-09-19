<?php
require_once 'config.php'; // sigurohu që ky file është në të njëjtin folder

$email = 'admin@example.com';
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo "User nuk u gjet me email: $email";
    exit;
}

echo "Gjetur user: " . htmlspecialchars($user['name']) . "<br>";
echo "Role: " . htmlspecialchars($user['role']) . "<br>";
echo "Password hash: " . htmlspecialchars($user['password']) . "<br>";

$plain = 'admin123'; // vendos fjalëkalimin që dëshiron të provosh
if (isset($user['password']) && password_verify($plain, $user['password'])) {
    echo "<b>password_verify OK: '$plain' përputhet me hash</b>";
} else {
    echo "<b>password_verify NOK: '$plain' nuk përputhet me hash</b>";
}
