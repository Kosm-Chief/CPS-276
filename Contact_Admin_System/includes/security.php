<?php
// Session is handled in index.php

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isAuthenticated() && $_SESSION['user']['status'] === 'admin';
}

function requireLogin() {
    if (!isAuthenticated()) {
        header('Location: index.php?page=login');
        exit;
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php?page=welcome');
        exit;
    }
}

function logout() {
    // Don't start a new session here since it's already started
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

/**
 * Hash a password for storing
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify a stored password against a given password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Authenticate user
 */
function authenticateUser($email, $password) {
    $db = new Db_conn();
    $pdo = $db->connect();
    $methods = new Pdo_methods();

    $sql = "SELECT * FROM admins WHERE email = ?";
    $bindings = array($email);
    
    $records = $methods->selectBinded($sql, $bindings);
    
    if ($records === false) {
        return false;
    }
    
    if (count($records) === 1) {
        $user = $records[0];
        if (verifyPassword($password, $user['password'])) {
            // Set session data
            $_SESSION['user'] = array(
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'status' => $user['status']
            );
            return true;
        }
    }
    
    return false;
}
?> 