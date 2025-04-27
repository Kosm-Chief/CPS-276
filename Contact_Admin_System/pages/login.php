<?php
// pages/login.php

if (isset($_SESSION['status'])) {
    header('Location: index.php?page=welcome');
    exit();
}

require_once 'classes/StickyForm.php';
$sticky = new StickyForm();
$pdo = new PdoMethods();
$message = "";

// Default blank form fields
$elementsArr = [
    "email" => ["value" => "", "error" => ""],
    "password" => ["value" => "", "error" => ""]
];

// If the form was submitted
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $elementsArr['email']['value'] = $email;
    $elementsArr['password']['value'] = $password;

    if (empty($email)) {
        $elementsArr['email']['error'] = "Email is required.";
    }

    if (empty($password)) {
        $elementsArr['password']['error'] = "Password is required.";
    }

    if (empty($elementsArr['email']['error']) && empty($elementsArr['password']['error'])) {
        $sql = "SELECT name, email, password, status FROM admins WHERE email = :email";
        $bindings = [
            [':email', $email, 'str']
        ];
        $result = $pdo->selectBinded($sql, $bindings);

        if ($result == 'error') {
            $message = "<p class='text-danger'>There was a problem logging in.</p>";
        } else {
            if (count($result) != 0) {
                if (password_verify($password, $result[0]['password'])) {
                    $_SESSION['name'] = $result[0]['name'];
                    $_SESSION['status'] = $result[0]['status'];
                    header('Location: index.php?page=welcome');
                    exit();
                } else {
                    $message = "<p class='text-danger'>Invalid Credentials.</p>";
                }
            } else {
                $message = "<p class='text-danger'>Invalid Credentials.</p>";
            }
        }
    } else {
        $message = "<p class='text-danger'>Please fix errors below.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php echo $message; ?>
    <form method="post" action="index.php?page=login">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="text" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($elementsArr['email']['value']); ?>">
            <span class="text-danger"><?php echo $elementsArr['email']['error']; ?></span>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" 
                   value="<?php echo htmlspecialchars($elementsArr['password']['value']); ?>">
            <span class="text-danger"><?php echo $elementsArr['password']['error']; ?></span>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
