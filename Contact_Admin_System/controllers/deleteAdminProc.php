<?php
require_once '../classes/Db_conn.php';
require_once '../classes/Validation.php';
require_once '../classes/Pdo_methods.php';

session_start();

$db = new Db_conn();
$pdo = $db->connect();
$methods = new Pdo_methods();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['admin_ids'])) {
        // Don't allow deleting the last admin
        $sql = "SELECT COUNT(*) as count FROM admins WHERE status = 'admin'";
        $result = $methods->selectBinded($sql, []);
        $adminCount = $result[0]['count'];
        
        // Convert admin_ids to proper binding format
        $bindings = array_map(function($id) {
            return [1, $id, 'int'];
        }, $_POST['admin_ids']);
        
        $sql = "SELECT COUNT(*) as count FROM admins WHERE status = 'admin' AND id IN (" . 
               str_repeat('?,', count($_POST['admin_ids']) - 1) . "?)";
        $result = $methods->selectBinded($sql, $bindings);
        $deletingAdminCount = $result[0]['count'];
        
        if ($adminCount - $deletingAdminCount <= 0) {
            $_SESSION['error'] = "Cannot delete the last admin";
            header('Location: ../index.php?page=deleteAdmins');
            exit;
        } else {
            $placeholders = str_repeat('?,', count($_POST['admin_ids']) - 1) . '?';
            $sql = "DELETE FROM admins WHERE id IN ($placeholders)";
            
            try {
                $result = $methods->otherBinded($sql, $bindings);
                
                if ($result == 'noerror') {
                    $_SESSION['success'] = "Admin(s) deleted successfully";
                } else {
                    $_SESSION['error'] = "Database error occurred while deleting admins";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
            }
            
            header('Location: ../index.php?page=deleteAdmins');
            exit;
        }
    } else {
        $_SESSION['error'] = "Please select at least one admin to delete";
        header('Location: ../index.php?page=deleteAdmins');
        exit;
    }
} else {
    header('Location: ../index.php?page=deleteAdmins');
    exit;
}
?> 