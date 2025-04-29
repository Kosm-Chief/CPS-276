<?php
require_once '../classes/Pdo_methods.php';
require_once '../classes/StickyForm.php';
require_once '../classes/Validation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sticky = new StickyForm();

    $validation = [
        'fname' => ['regex' => '/^[a-zA-Z\s]+$/', 'required' => true],
        'lname' => ['regex' => '/^[a-zA-Z\s]+$/', 'required' => true],
        'email' => ['regex' => '/.+@.+\..+/', 'required' => true],
        'phone' => ['regex' => '/^[0-9\.\-]+$/', 'required' => true],
        'address' => ['regex' => '/.+/', 'required' => true],
        'city' => ['regex' => '/^[a-zA-Z\s]+$/', 'required' => true],
        'state' => ['regex' => '/^[a-zA-Z\s]+$/', 'required' => true],
        'zip' => ['regex' => '/^\d{5}$/', 'required' => true],
        'dob' => ['regex' => '/^\d{4}-\d{2}-\d{2}$/', 'required' => true],
        'age_range' => ['regex' => '/.+/', 'required' => true]
    ];

    $errors = $sticky->validateForm($_POST, $validation);

    if (empty($errors)) {
        $pdo = new Pdo_methods();

        $contactOptions = isset($_POST['contact_options']) ? implode(', ', $_POST['contact_options']) : '';

        // 🔥 Calculate AGE based on DOB
        $dob = new DateTime($_POST['dob']);
        $today = new DateTime();
        $age = $today->diff($dob)->y;

        $sql = "INSERT INTO contacts (fname, lname, address, city, state, zip, phone, email, dob, age, age_range, contact_options)
                VALUES (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :age, :age_range, :contact_options)";

        $bindings = [
            ['name' => ':fname', 'value' => $_POST['fname'], 'type' => PDO::PARAM_STR],
            ['name' => ':lname', 'value' => $_POST['lname'], 'type' => PDO::PARAM_STR],
            ['name' => ':address', 'value' => $_POST['address'], 'type' => PDO::PARAM_STR],
            ['name' => ':city', 'value' => $_POST['city'], 'type' => PDO::PARAM_STR],
            ['name' => ':state', 'value' => $_POST['state'], 'type' => PDO::PARAM_STR],
            ['name' => ':zip', 'value' => $_POST['zip'], 'type' => PDO::PARAM_STR],
            ['name' => ':phone', 'value' => $_POST['phone'], 'type' => PDO::PARAM_STR],
            ['name' => ':email', 'value' => $_POST['email'], 'type' => PDO::PARAM_STR],
            ['name' => ':dob', 'value' => $_POST['dob'], 'type' => PDO::PARAM_STR],
            ['name' => ':age', 'value' => $age, 'type' => PDO::PARAM_INT], // 🔥 Now inserting age
            ['name' => ':age_range', 'value' => $_POST['age_range'], 'type' => PDO::PARAM_STR],
            ['name' => ':contact_options', 'value' => $contactOptions, 'type' => PDO::PARAM_STR]
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        header("Location: ../index.php?page=addContact&message=" . urlencode($result));
        exit();
    } else {
        header("Location: ../index.php?page=addContact&error=" . urlencode(json_encode($errors)) . "&formData=" . urlencode(json_encode($_POST)));
        exit();
    }
}
?>
