<?php
require_once '../classes/Pdo_methods.php';
require_once '../classes/StickyForm.php';
require_once '../classes/Validation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sticky = new StickyForm();

    $validation = [
        'name' => ['regex' => '/.+/', 'required' => true],
        'email' => ['regex' => '/.+@.+\..+/', 'required' => true],
        'password' => ['regex' => '/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/', 'required' => true]
    ];

    $errors = $sticky->validateForm($_POST, $validation);

    if (empty($errors)) {
        $pdo = new Pdo_methods();
        
        $sql = "INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)";

        $bindings = [
            [
                'name' => ':name',
                'value' => $_POST['name'],
                'type' => PDO::PARAM_STR
            ],
            [
                'name' => ':email',
                'value' => $_POST['email'],
                'type' => PDO::PARAM_STR
            ],
            [
                'name' => ':password',
                'value' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'type' => PDO::PARAM_STR
            ]
        ];
        
        $result = $pdo->otherBinded($sql, $bindings);

        header("Location: ../index.php?page=addAdmin&message=" . urlencode($result));
        exit();
    } else {
        header("Location: ../index.php?page=addAdmin&error=" . urlencode(json_encode($errors)));
        exit();
    }
}
?>
