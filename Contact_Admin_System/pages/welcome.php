<?php
// pages/welcome.php

// Make sure only logged-in users can see this page
if (!isset($_SESSION['name']) || !isset($_SESSION['status'])) {
    header('Location: index.php?page=login');
    exit();
}

// Store the user info
$name = $_SESSION['name'];
$status = $_SESSION['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
    <ul class="list-group mt-4">

        <li class="list-group-item">
            <a href="index.php?page=addContact">Add Contact</a>
        </li>
        <li class="list-group-item">
            <a href="index.php?page=deleteContacts">Delete Contact(s)</a>
        </li>

        <?php if ($status === 'admin') { ?>
            <li class="list-group-item">
                <a href="index.php?page=addAdmin">Add Admin</a>
            </li>
            <li class="list-group-item">
                <a href="index.php?page=deleteAdmins">Delete Admin(s)</a>
            </li>
        <?php } ?>

        <li class="list-group-item">
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</div>
</body>
</html>
