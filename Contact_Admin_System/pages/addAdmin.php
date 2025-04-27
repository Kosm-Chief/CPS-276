<?php
if (!isset($_SESSION['name']) || !isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header('Location: index.php?page=login');
    exit();
}

require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

$sticky = new StickyForm();
$pdo = new PdoMethods();
$message = "";

// Form configuration
$formConfig = [
    "masterStatus" => ["error" => false],
    "name" => [
        "error" => "", "type" => "text", "regex" => "name", "value" => "", "label" => "Name",
        "id" => "name", "name" => "name"
    ],
    "email" => [
        "error" => "", "type" => "text", "regex" => "email", "value" => "", "label" => "Email",
        "id" => "email", "name" => "email"
    ],
    "password" => [
        "error" => "", "type" => "text", "regex" => "password", "value" => "", "label" => "Password",
        "id" => "password", "name" => "password"
    ],
    "status" => [
        "error" => "", "type" => "select", "required" => true, "value" => "", "selected" => "", "label" => "Status",
        "id" => "status", "name" => "status",
        "options" => [
            "" => "Select Status",
            "admin" => "admin",
            "staff" => "staff"
        ]
    ]
];

// Handle form submission
if (isset($_POST['submit'])) {
    $formConfig = $sticky->validateForm($_POST, $formConfig);

    if (!$formConfig['masterStatus']['error']) {
        // Check if email already exists
        $sql = "SELECT email FROM admins WHERE email = :email";
        $bindings = [
            [':email', $formConfig['email']['value'], 'str']
        ];
        $records = $pdo->selectBinded($sql, $bindings);

        if ($records === 'error') {
            $message = "<p class='text-danger'>There was a problem checking the email.</p>";
        } elseif (!empty($records)) {
            $message = "<p class='text-danger'>That email is already in use.</p>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($formConfig['password']['value'], PASSWORD_DEFAULT);

            // Insert new admin
            $sql = "INSERT INTO admins (name, email, password, status) 
                    VALUES (:name, :email, :password, :status)";
            $bindings = [
                [':name', $formConfig['name']['value'], 'str'],
                [':email', $formConfig['email']['value'], 'str'],
                [':password', $hashedPassword, 'str'],
                [':status', $formConfig['status']['selected'], 'str']
            ];
            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $message = "<p class='text-danger'>There was a problem adding the admin.</p>";
            } else {
                $message = "<p class='text-success'>Admin Added Successfully!</p>";

                // Clear form after success
                foreach ($formConfig as $key => &$field) {
                    if ($key !== 'masterStatus') {
                        if (isset($field['value'])) $field['value'] = '';
                        if (isset($field['selected'])) $field['selected'] = '';
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Admin</h2>
    <?php echo $message; ?>
    <form method="post" action="index.php?page=addAdmin">
        <?php
        echo $sticky->renderInput($formConfig['name']);
        echo $sticky->renderInput($formConfig['email']);
        echo $sticky->renderInput($formConfig['password']);
        echo $sticky->renderSelect($formConfig['status']);
        ?>
        <button type="submit" name="submit" class="btn btn-primary mt-3">Add Admin</button>
    </form>
</div>
</body>
</html>
