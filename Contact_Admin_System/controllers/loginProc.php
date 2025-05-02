<?php
session_start(); // Ensure session is started
require_once '../includes/security.php';
require_once '../classes/Db_conn.php';
require_once '../classes/Pdo_methods.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Debug logging
    error_log("Login attempt - Email: " . $email);
    
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
        error_log("Empty fields detected");
        header('Location: ../index.php?page=login');
        exit;
    }
    
    try {
        $db = new Db_conn();
        $pdo = $db->connect();
        
        if (!$pdo) {
            error_log("Database connection failed in loginProc.php");
            throw new Exception("Database connection failed");
        }
        
        $methods = new Pdo_methods();
        $sql = "SELECT * FROM admins WHERE email = ?";
        $bindings = array($email);
        
        $records = $methods->selectBinded($sql, $bindings);
        error_log("Query results: " . print_r($records, true));
        
        if ($records === false) {
            error_log("Database query failed in loginProc.php");
            throw new Exception("Database query failed");
        }
        
        if (count($records) === 1) {
            $user = $records[0];
            error_log("Found user: " . print_r($user, true));
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = array(
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'status' => $user['status']
                );
                error_log("Login successful for user: " . $user['email']);
                header('Location: ../index.php?page=welcome');
                exit;
            }
            error_log("Password verification failed");
        }
        
        $_SESSION['error'] = "Invalid email or password";
        error_log("Invalid credentials - Email: " . $email);
        header('Location: ../index.php?page=login');
        exit;
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = "A system error occurred. Please try again.";
        header('Location: ../index.php?page=login');
        exit;
    }
} else {
    header('Location: ../index.php?page=login');
    exit;
} 