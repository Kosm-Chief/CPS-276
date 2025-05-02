<?php
require_once '../classes/Db_conn.php';
require_once '../classes/Validation.php';
require_once '../classes/StickyForm.php';
require_once '../classes/Pdo_methods.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validate = new Validation();
    $errors = [];
    
    // Store POST data in session for sticky form
    $stickyForm = new StickyForm();
    $_SESSION['post'] = $_POST;
    
    // Validate name
    if(empty($_POST['name']) || !$validate->checkName($_POST['name'])) {
        $errors[] = "Name is required and must contain only letters";
    }
    
    // Validate email
    if(empty($_POST['email']) || !$validate->checkEmail($_POST['email'])) {
        $errors[] = "Please enter a valid email";
    }
    
    // Validate password
    if(empty($_POST['password'])) {
        $errors[] = "Password is required";
    }
    
    // Validate status
    if(empty($_POST['status']) || !in_array($_POST['status'], ['admin', 'staff'])) {
        $errors[] = "Please select a valid status";
    }

    if(empty($errors)) {
        $pdo = new Pdo_methods();

        // Check for duplicate email
        $sql = "SELECT COUNT(*) as count FROM admins WHERE email = :email";
        $bindings = [[':email', $_POST['email'], 'str']];
        
        $result = $pdo->selectBinded($sql, $bindings);
        
        if($result[0]['count'] > 0) {
            $_SESSION['error'] = "An admin with this email already exists";
        } else {
            // Hash the password
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO admins (name, email, password, status) VALUES (:name, :email, :password, :status)";
            
            $bindings = [
                [':name', $_POST['name'], 'str'],
                [':email', $_POST['email'], 'str'],
                [':password', $hashedPassword, 'str'],
                [':status', $_POST['status'], 'str']
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if($result === 'error'){
                $_SESSION['error'] = "There was an error adding the admin";
            }
            else {
                $_SESSION['success'] = "Admin has been added";
                // Clear the form data from session after successful submission
                unset($_SESSION['post']);
            }
        }
    }
    else {
        $_SESSION['error'] = "Please fix the following errors:<br>" . implode("<br>", $errors);
    }
}

header('Location: ../index.php?page=addAdmin');
exit;
?> 