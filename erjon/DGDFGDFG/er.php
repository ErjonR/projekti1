<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formular Kontakti</title>
</head>
<body>
    <h1>Kontakt</h1>
    <form id="contactForm">
        <label for="name">Emri:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="message">Mesazhi:</label>
        <textarea id="message" name="message" required></textarea><br><br>
        
        <button type="submit">Dërgo</button>
    </form>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (name && email && message) {
                alert("Emaili është dërguar me sukses!");
            } else {
                alert("Please complete all your details!");
            }
        });
    </script>
    <scrip src="main.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>