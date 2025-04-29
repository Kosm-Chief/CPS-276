<?php
require_once 'includes/security.php';

// No protectPage() here because login page must be open for everyone
?>

<h2>Login</h2>

<?php
// Display any login message (like "Incorrect email" or "Access denied")
if (isset($_GET['message'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['message']) . '</div>';
}

// Display any validation errors passed back safely
if (isset($_GET['error'])) {
    $errors = json_decode($_GET['error'], true);
    if (is_array($errors)) { // SAFETY CHECK
        foreach ($errors as $field => $errorArray) {
            foreach ($errorArray as $errorMessage) {
                echo '<div class="alert alert-danger">' . htmlspecialchars(ucfirst($field) . ': ' . $errorMessage) . '</div>';
            }
        }
    }
}
?>

<form method="post" action="controllers/loginProc.php" class="mb-3">
    <div class="mb-3">
        <label for="email" class="form-label">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Login</button>  <!-- <<< Proper button inside div -->
    </div>
</form>
