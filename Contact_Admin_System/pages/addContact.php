<?php
if (!isset($_SESSION['name']) || !isset($_SESSION['status'])) {
    header('Location: index.php?page=login');
    exit();
}

require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

$sticky = new StickyForm();
$pdo = new PdoMethods();
$message = "";

// Form configuration array
$formConfig = [
    "masterStatus" => ["error" => false],
    "fname" => [
        "error" => "", "type" => "text", "regex" => "name", "value" => "", "label" => "First Name",
        "id" => "fname", "name" => "fname"
    ],
    "lname" => [
        "error" => "", "type" => "text", "regex" => "name", "value" => "", "label" => "Last Name",
        "id" => "lname", "name" => "lname"
    ],
    "address" => [
        "error" => "", "type" => "text", "regex" => "address", "value" => "", "label" => "Address",
        "id" => "address", "name" => "address"
    ],
    "city" => [
        "error" => "", "type" => "text", "regex" => "city", "value" => "", "label" => "City",
        "id" => "city", "name" => "city"
    ],
    "state" => [
        "error" => "", "type" => "select", "required" => true, "value" => "", "selected" => "", "label" => "State",
        "id" => "state", "name" => "state",
        "options" => [
            "" => "Select State",
            "MI" => "MI",
            "OH" => "OH",
            "IN" => "IN",
            "IL" => "IL",
            "WI" => "WI"
        ]
    ],
    "zip" => [
        "error" => "", "type" => "text", "regex" => "zip", "value" => "", "label" => "Zip Code",
        "id" => "zip", "name" => "zip"
    ],
    "phone" => [
        "error" => "", "type" => "text", "regex" => "phone", "value" => "", "label" => "Phone Number (Format: 999.999.9999)",
        "id" => "phone", "name" => "phone"
    ],
    "email" => [
        "error" => "", "type" => "text", "regex" => "email", "value" => "", "label" => "Email Address",
        "id" => "email", "name" => "email"
    ],
    "dob" => [
        "error" => "", "type" => "text", "regex" => "dob", "value" => "", "label" => "Date of Birth (Format: mm/dd/yyyy)",
        "id" => "dob", "name" => "dob"
    ],
    "contacts" => [
        "error" => "", "type" => "checkbox", "required" => false,
        "id" => "contacts", "name" => "contacts",
        "label" => "Preferred Contact Methods",
        "options" => [
            ["value" => "Email Updates", "label" => "Email Updates", "checked" => false],
            ["value" => "Text Alerts", "label" => "Text Alerts", "checked" => false],
            ["value" => "Newsletter", "label" => "Newsletter", "checked" => false]
        ]
    ],
    "age" => [
        "error" => "", "type" => "radio", "required" => true,
        "id" => "age", "name" => "age",
        "label" => "Age Range",
        "options" => [
            ["value" => "18-24", "label" => "18-24", "checked" => false],
            ["value" => "25-34", "label" => "25-34", "checked" => false],
            ["value" => "35-44", "label" => "35-44", "checked" => false],
            ["value" => "45+", "label" => "45+", "checked" => false]
        ]
    ]
];

// Handle form submission
if (isset($_POST['submit'])) {
    $formConfig = $sticky->validateForm($_POST, $formConfig);

    if (!$formConfig['masterStatus']['error']) {
        // Prepare checkbox values
        $contactsSelected = [];
        foreach ($formConfig['contacts']['options'] as $option) {
            if ($option['checked']) {
                $contactsSelected[] = $option['value'];
            }
        }
        $contacts = implode(", ", $contactsSelected);

        // Get selected age
        $age = "";
        foreach ($formConfig['age']['options'] as $option) {
            if ($option['checked']) {
                $age = $option['value'];
            }
        }

        $sql = "INSERT INTO contacts (fname, lname, address, city, state, zip, phone, email, dob, contacts, age)
                VALUES (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :contacts, :age)";

        $bindings = [
            [':fname', $formConfig['fname']['value'], 'str'],
            [':lname', $formConfig['lname']['value'], 'str'],
            [':address', $formConfig['address']['value'], 'str'],
            [':city', $formConfig['city']['value'], 'str'],
            [':state', $formConfig['state']['selected'], 'str'],
            [':zip', $formConfig['zip']['value'], 'str'],
            [':phone', $formConfig['phone']['value'], 'str'],
            [':email', $formConfig['email']['value'], 'str'],
            [':dob', $formConfig['dob']['value'], 'str'],
            [':contacts', $contacts, 'str'],
            [':age', $age, 'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'error') {
            $message = "<p class='text-danger'>There was an error adding the contact.</p>";
        } else {
            $message = "<p class='text-success'>Contact Information Added!</p>";

            // Properly clear the form fields after successful submit
            foreach ($formConfig as $key => &$field) {
                if ($key !== 'masterStatus') {
                    if (isset($field['type']) && $field['type'] == 'checkbox' && isset($field['options'])) {
                        foreach ($field['options'] as &$option) {
                            $option['checked'] = false;
                        }
                    } elseif (isset($field['type']) && $field['type'] == 'radio' && isset($field['options'])) {
                        foreach ($field['options'] as &$option) {
                            $option['checked'] = false;
                        }
                    } elseif (isset($field['value'])) {
                        $field['value'] = '';
                    } elseif (isset($field['selected'])) {
                        $field['selected'] = '';
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
    <title>Add Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Contact</h2>
    <?php echo $message; ?>
    <form method="post" action="index.php?page=addContact">
        <?php
        echo $sticky->renderInput($formConfig['fname']);
        echo $sticky->renderInput($formConfig['lname']);
        echo $sticky->renderInput($formConfig['address']);
        echo $sticky->renderInput($formConfig['city']);
        echo $sticky->renderSelect($formConfig['state']);
        echo $sticky->renderInput($formConfig['zip']);
        echo $sticky->renderInput($formConfig['phone']);
        echo $sticky->renderInput($formConfig['email']);
        echo $sticky->renderInput($formConfig['dob']);

        echo '<div class="mb-3">';
        echo '<label>' . $formConfig['contacts']['label'] . '</label><br>';
        foreach ($formConfig['contacts']['options'] as $option) {
            $checked = $option['checked'] ? 'checked' : '';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" id="' . $option['value'] . '" name="contacts[]" value="' . $option['value'] . '" ' . $checked . '>';
            echo '<label class="form-check-label" for="' . $option['value'] . '">' . $option['label'] . '</label>';
            echo '</div>';
        }
        echo '</div>';

        echo $sticky->renderRadio($formConfig['age']);
        ?>
        <button type="submit" name="submit" class="btn btn-primary mt-3">Add Contact</button>
    </form>
</div>
</body>
</html>
