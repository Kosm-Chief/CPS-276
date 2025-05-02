<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

function init() {
    $links = '';
    if ($_SESSION['user']['status'] == 'admin') {
        $links = <<<HTML
        <a href="index.php?page=addContact" class="nav-link">Add Contact</a>
        <a href="index.php?page=deleteContacts" class="nav-link">Delete Contact(s)</a>
        <a href="index.php?page=addAdmin" class="nav-link">Add Admin</a>
        <a href="index.php?page=deleteAdmins" class="nav-link">Delete Admin(s)</a>
        <a href="logout.php" class="nav-link">Logout</a>
HTML;
    } else {
        $links = <<<HTML
        <a href="index.php?page=addContact" class="nav-link">Add Contact</a>
        <a href="index.php?page=deleteContacts" class="nav-link">Delete Contact(s)</a>
        <a href="logout.php" class="nav-link">Logout</a>
HTML;
    }

    return <<<HTML
    <nav class="nav">
        $links
    </nav>
    <div class="container mt-4">
        <h1>Welcome Page</h1>
        <p>Welcome {$_SESSION['user']['name']}</p>
    </div>
HTML;
}
?>