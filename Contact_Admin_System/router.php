<?php
// project_root/router.php

switch ($page) {
    case 'login':
        require_once 'pages/login.php';
        break;
    case 'welcome':
        require_once 'pages/welcome.php';
        break;
    case 'addContact':
        require_once 'pages/addContact.php';
        break;
    case 'deleteContacts':
        require_once 'pages/deleteContacts.php';
        break;
    case 'addAdmin':
        require_once 'pages/addAdmin.php';
        break;
    case 'deleteAdmins':
        require_once 'pages/deleteAdmins.php';
        break;
}
?>
