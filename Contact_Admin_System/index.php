<?php
// Start the session for tracking users
session_start();

// Bring in the helper classes you need
require_once "classes/Db_conn.php";
require_once "classes/Pdo_methods.php";
require_once "classes/StickyForm.php";
require_once "classes/Validation.php";

// Check if a page parameter is set (ex: ?page=addContact)
// If not set, or wrong, send to 'login' page
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$allowed_pages = ['login', 'welcome', 'addContact', 'deleteContacts', 'addAdmin', 'deleteAdmins'];

if (!in_array($page, $allowed_pages)) {
    header('Location: index.php?page=login');
    exit();
}

// Check if user is NOT logged in and trying to access anything other than login page
if (!isset($_SESSION['status']) && $page != 'login') {
    header('Location: index.php?page=login');
    exit();
}

// Check if staff tries to access admin-only pages
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] == 'staff' && ($page == 'addAdmin' || $page == 'deleteAdmins')) {
        header('Location: index.php?page=welcome');
        exit();
    }
}

// If all checks pass, load the router file
require_once "router.php";
?>
