<?php
include '../config.php';
$result = $conn->query("SELECT * FROM cart");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
</head>
<body>
    <h1>Produktet në shportë</h1>
    <table border="1" cellpadding="8">
        <tr><th>ID</th><th>Emri</th><th>Cmimi</th><th>Sasia</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['product_name'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['quantity'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
