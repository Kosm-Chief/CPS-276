<?php
// Session is already started in index.php
$path = "index.php?page=login";
$content = '';

// Define protected pages that require admin access
$adminPages = ['addAdmin', 'deleteAdmins'];

// If not logged in, only allow access to login page
if(!isset($_SESSION['user']) && (!isset($_GET['page']) || $_GET['page'] !== 'login')) {
    $_SESSION['error'] = "Please log in to access this page";
    header('Location: ' . $path);
    exit;
}

// If logged in but trying to access login page, redirect to welcome
if(isset($_SESSION['user']) && isset($_GET['page']) && $_GET['page'] === 'login') {
    header('Location: index.php?page=welcome');
    exit;
}

if(isset($_GET['page'])){
    // Check if trying to access admin page without admin privileges
    if(in_array($_GET['page'], $adminPages) && (!isset($_SESSION['user']) || $_SESSION['user']['status'] !== 'admin')) {
        $_SESSION['error'] = "You do not have permission to access this page";
        header('Location: index.php?page=welcome');
        exit;
    }

    switch($_GET['page']) {
        case 'login':
            require_once('views/loginForm.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;

        case 'welcome':
            requireLogin();
            require_once('views/welcome.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;

        case 'addContact':
            requireLogin();
            require_once('views/addContactView.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;
            
        case 'deleteContacts':
            requireLogin();
            require_once('views/deleteContactView.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;

        case 'addAdmin':
            requireAdmin();
            require_once('views/addAdminForm.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;

        case 'deleteAdmins':
            requireAdmin();
            require_once('views/deleteAdminsTable.php');
            if (function_exists('init')) {
                $content = init();
            }
            break;

        default:
            $_SESSION['error'] = "Page not found";
            header('location: '.$path);
            exit;
    }
}
else {
    header('location: '.$path);
    exit;
}
?>