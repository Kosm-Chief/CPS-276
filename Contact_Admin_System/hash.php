<?php
// Small tool to hash any password
if (isset($_POST['password'])) {
    echo '<strong>Hashed Password:</strong><br>';
    echo password_hash($_POST['password'], PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hash Generator</title>
</head>
<body>
    <h2>Enter a Password to Hash</h2>
    <form method="post">
        <input type="text" name="password" placeholder="Enter password" required>
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>
