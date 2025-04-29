<?php
$nav = '<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=welcome">Home</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">';

if (isset($_SESSION['access']) && $_SESSION['access'] === 'granted') {
    
    if ($_SESSION['status'] === 'admin') {
        $nav .= '
            <li class="nav-item"><a class="nav-link" href="index.php?page=addAdmin">Add Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?page=deleteAdmins">Delete Admins</a></li>';
    }

    // Common links for both Admin and Staff
    $nav .= '
        <li class="nav-item"><a class="nav-link" href="index.php?page=addContact">Add Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=deleteContacts">Delete Contacts</a></li>
        <li class="nav-item"><a class="nav-link" href="controllers/logout.php">Logout</a></li>';
}

$nav .= '</ul></div></div></nav>';
?>
