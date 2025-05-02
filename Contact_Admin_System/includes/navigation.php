<?php
$nav = '';

// Build the navigation links
$nav = '<div class="nav">';

if (isAuthenticated()) {
    $nav .= '<a href="index.php?page=addContact" class="nav-link">Add Contact</a>';
    $nav .= '<a href="index.php?page=deleteContacts" class="nav-link">Delete Contact(s)</a>';
    
    if (isAdmin()) {
        $nav .= '<a href="index.php?page=addAdmin" class="nav-link">Add Admin</a>';
        $nav .= '<a href="index.php?page=deleteAdmins" class="nav-link">Delete Admin(s)</a>';
    }
    
    $nav .= '<a href="logout.php" class="nav-link">Logout</a>';
}

$nav .= '</div>';
?>