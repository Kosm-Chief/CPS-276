<?php
require_once '../classes/Pdo_methods.php';
require_once '../classes/StickyForm.php';
require_once '../classes/Validation.php';
require_once '../includes/security.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['email'] = trim($_POST['email']);
    $_POST['password'] = trim($_POST['password']);

    $errors = [];

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ['Invalid email format'];
    }

    if (empty($_POST['password'])) {
        $errors['password'] = ['Password cannot be empty'];
    }

    if (!empty($errors)) {
        header("Location: ../index.php?page=login&error=" . urlencode(json_encode($errors)));
        exit();
    }

    $pdo = new Pdo_methods();

    $sql = "SELECT id, name, email, password, status FROM admins WHERE email = :email";
    $bindings = [
        ['name' => ':email', 'value' => $_POST['email'], 'type' => PDO::PARAM_STR]
    ];

    $records = $pdo->selectBinded($sql, $bindings);

    if ($records == 'error' || empty($records)) {
        header("Location: ../index.php?page=login&message=" . urlencode("Login failed. Incorrect email or password."));
        exit();
    } else {
        
  

        if (password_verify($_POST['password'], $records[0]['password'])) {
            $_SESSION['access'] = "granted";
            $_SESSION['name'] = $records[0]['name'];
            $_SESSION['status'] = $records[0]['status']; // admin or staff
            header("Location: ../index.php?page=welcome");
            exit();
        } else {
            header("Location: ../index.php?page=login&message=" . urlencode("Login failed. Incorrect email or password."));
            exit();
        }
    }
}
?>
