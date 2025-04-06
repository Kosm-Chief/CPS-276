<?php
require_once "classes/StickyForm.php";
require_once "classes/Validation.php";
require_once "classes/Db_conn.php";
require_once "classes/Pdo_methods.php";

$stickyForm = new StickyForm();
$validation = new Validation();
$pdo = new PdoMethods();

$formElements = [
  "firstName" => "", "lastName" => "", "email" => "",
  "password" => "", "confirmPassword" => ""
];

$messages = [];
$records = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formElements = $_POST;

    // VALIDATION EXAMPLES:
    if (!$validation->name($formElements["firstName"])) {
        $messages[] = "Invalid First Name";
    }

    if (!$validation->name($formElements["lastName"])) {
        $messages[] = "Invalid Last Name";
    }

    if (!$validation->email($formElements["email"])) {
        $messages[] = "Invalid Email";
    }

    if (!$validation->password($formElements["password"])) {
        $messages[] = "Password must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)";
    }

    if ($formElements["password"] !== $formElements["confirmPassword"]) {
        $messages[] = "Your passwords do not match";
    }

    // Check for duplicate email
    $sql = "SELECT email FROM users WHERE email = :email";
    $bindings = [ [':email', $formElements["email"], 'str'] ];
    $result = $pdo->selectBinded($sql, $bindings);

    if ($result !== 'error' && count($result) > 0) {
        $messages[] = "There is already a record with that email";
    }

    // INSERT RECORD
    if (empty($messages)) {
        $hash = password_hash($formElements["password"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first, :last, :email, :pass)";
        $bindings = [
            [':first', $formElements["firstName"], 'str'],
            [':last', $formElements["lastName"], 'str'],
            [':email', $formElements["email"], 'str'],
            [':pass', $hash, 'str']
        ];
        $pdo->otherBinded($sql, $bindings);

        $messages[] = "You have been added to the database";
        $formElements = ["firstName" => "", "lastName" => "", "email" => "", "password" => "", "confirmPassword" => ""];
    }

    // DISPLAY RECORDS
    $recordsResult = $pdo->selectNotBinded("SELECT * FROM users");
    if ($recordsResult !== 'error' && count($recordsResult) > 0) {
        $records .= "<table class='table mt-4'><thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th></tr></thead><tbody>";
        foreach ($recordsResult as $row) {
            $records .= "<tr><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['email']}</td><td>{$row['password']}</td></tr>";
        }
        $records .= "</tbody></table>";
    } else {
        $records = "<p>No records to display.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <?php foreach ($messages as $msg): ?>
      <div class="text-danger mb-2"><?= $msg ?></div>
    <?php endforeach; ?>

    <form method="POST">
      <div class="row mb-3">
        <div class="col">
          <label for="firstName" class="form-label">First Name</label>
          <input type="text" name="firstName" class="form-control" value="<?= htmlspecialchars($formElements['firstName']) ?>">
        </div>
        <div class="col">
          <label for="lastName" class="form-label">Last Name</label>
          <input type="text" name="lastName" class="form-control" value="<?= htmlspecialchars($formElements['lastName']) ?>">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($formElements['email']) ?>">
        </div>
        <div class="col">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" value="<?= htmlspecialchars($formElements['password']) ?>">
        </div>
        <div class="col">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" name="confirmPassword" class="form-control" value="<?= htmlspecialchars($formElements['confirmPassword']) ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <?= $records ?>
  </div>
</body>
</html>
