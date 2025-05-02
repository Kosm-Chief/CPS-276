<?php
require_once '../classes/Db_conn.php';
require_once '../classes/Pdo_methods.php';

session_start();
error_log("Delete contact process started");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['chkbx'])) {
        $db = new Db_conn();
        $pdo = $db->connect();
        $methods = new Pdo_methods();

        $placeholders = str_repeat('?,', count($_POST['chkbx']) - 1) . '?';
        $sql = "DELETE FROM contactMod WHERE id IN ($placeholders)";
        
        // Create bindings array in the format expected by the Pdo_methods class
        $bindings = [];
        foreach ($_POST['chkbx'] as $index => $id) {
            $bindings[] = [$index + 1, $id, 'int'];
        }
        
        $result = $methods->otherBinded($sql, $bindings);
        
        if ($result === 'noerror') {
            $_SESSION['success'] = "Contact(s) deleted successfully";
            error_log("Contacts deleted successfully");
        } else {
            $_SESSION['error'] = "Error deleting contact(s)";
            error_log("Delete contacts error: " . print_r($result, true));
        }
    } else {
        error_log("No contact IDs selected");
        $_SESSION['error'] = "Please select at least one contact to delete";
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

header('Location: ../index.php?page=deleteContacts');
exit;
?> 