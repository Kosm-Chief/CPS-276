<?php
ob_start(); // Start output buffering

$page = isset($_GET['page']) ? $_GET['page'] : 'welcome';

switch($page) {
    case 'addAdmin':
        include 'views/addAdminForm.php';
        break;
    case 'addContact':
        include 'views/addContactForm.php';
        break;
    case 'deleteAdmins':
        include 'views/deleteAdminsTable.php';
        break;
    case 'deleteContacts':
        include 'views/deleteContactsTable.php';
        break;
    case 'login':
        include 'views/loginForm.php';
        break;
    case 'welcome':
        include 'views/welcome.php';
        break;
    default:
        echo "<h2>Page Not Found</h2>";
        break;
}

$content = ob_get_clean(); // Save the buffer contents into $content
?>
