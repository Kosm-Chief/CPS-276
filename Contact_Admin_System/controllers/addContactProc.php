<?php
require_once '../classes/Db_conn.php';
require_once '../classes/Pdo_methods.php';
require_once '../classes/StickyForm.php';
require_once '../classes/Validation.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validate = new Validation();
    $errors = [];
    
    $stickyForm = new StickyForm();
    $_SESSION['post'] = $_POST;
    
    // Validate each field using the book's validation methods
    if(empty($_POST['fname']) || !$validate->checkName($_POST['fname'])) {
        $errors[] = "First name is required and must contain only letters";
    }
    
    if(empty($_POST['lname']) || !$validate->checkName($_POST['lname'])) {
        $errors[] = "Last name is required and must contain only letters";
    }
    
    if(!empty($_POST['email']) && !$validate->checkEmail($_POST['email'])) {
        $errors[] = "Please enter a valid email";
    }
    
    if(!empty($_POST['phone']) && !$validate->checkPhone($_POST['phone'])) {
        $errors[] = "Phone must be in format 999.999.9999";
    }
    
    if(empty($_POST['dob']) || !$validate->checkDob($_POST['dob'])) {
        $errors[] = "Date of birth is required and must be in format mm/dd/yyyy";
    }
    
    if(empty($_POST['contacts'])) {
        $errors[] = "Contact method is required";
    }

    if(empty($errors)) {
        $pdo = new Pdo_methods();

        // Check for duplicate email
        $sql = "SELECT COUNT(*) as count FROM contactMod WHERE email = :email";
        $bindings = [[':email', $_POST['email'], 'str']];
        
        $result = $pdo->selectBinded($sql, $bindings);
        
        if($result[0]['count'] > 0) {
            $_SESSION['error'] = "A contact with this email already exists";
        } else {
            $sql = "INSERT INTO contactMod (firstName, lastName, address, city, state, phone, email, dob, contacts, age) VALUES (:fname, :lname, :address, :city, :state, :phone, :email, :dob, :contacts, :age)";

            $bindings = [
                [':fname', $_POST['fname'], 'str'],
                [':lname', $_POST['lname'], 'str'],
                [':address', $_POST['address'], 'str'],
                [':city', $_POST['city'], 'str'],
                [':state', $_POST['state'], 'str'],
                [':phone', $_POST['phone'], 'str'],
                [':email', $_POST['email'], 'str'],
                [':dob', $_POST['dob'], 'str'],
                [':contacts', $_POST['contacts'], 'str'],
                [':age', $_POST['age'], 'str']
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if($result === 'error'){
                $_SESSION['error'] = "There was an error adding the contact";
            }
            else {
                $_SESSION['success'] = "Contact has been added";
                // Clear the form data from session after successful submission
                unset($_SESSION['post']);
            }
        }
    }
    else {
        $_SESSION['error'] = "Please fix the following errors:<br>" . implode("<br>", $errors);
    }
}

header('Location: ../index.php?page=addContact');
exit;
?> 