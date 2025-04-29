<?php
require_once 'includes/security.php';
protectPage('admin');
?>

<h2>Add Admin</h2>

<?php
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
if (isset($_GET['error'])) {
    $errors = json_decode($_GET['error'], true);
    foreach ($errors as $field => $errorArray) {
        foreach ($errorArray as $errorMessage) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($field . ': ' . $errorMessage) . '</div>';
        }
    }
}
?>

<form method="post" action="controllers/addAdminProc.php" class="mb-3">
    <div class="mb-3">
        <label for="name" class="form-label">Full Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="form-text">
            Must be at least 8 characters, 1 uppercase, 1 number, and 1 special character.
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Add Admin</button>
</form>
