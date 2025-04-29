<?php
require_once 'includes/security.php';
protectPage();

// Capture old form data for sticky form
$formData = [];
if (isset($_GET['formData'])) {
    $formData = json_decode($_GET['formData'], true);
}
?>

<h2>Add Contact</h2>

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

<form method="post" action="controllers/addContactProc.php" class="mb-3">
    <div class="row mb-3">
        <div class="col">
            <label for="fname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($formData['fname'] ?? ''); ?>" required>
        </div>
        <div class="col">
            <label for="lname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo htmlspecialchars($formData['lname'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Address:</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($formData['address'] ?? ''); ?>" required>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="city" class="form-label">City:</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($formData['city'] ?? ''); ?>" required>
        </div>
        <div class="col">
            <label for="state" class="form-label">State:</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($formData['state'] ?? ''); ?>" required>
        </div>
        <div class="col">
            <label for="zip" class="form-label">Zip Code:</label>
            <input type="text" class="form-control" id="zip" name="zip" value="<?php echo htmlspecialchars($formData['zip'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>" required>
        </div>
        <div class="col">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required>
        </div>
        <div class="col">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($formData['dob'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Choose an Age Range:</label><br>
        <input type="radio" id="0-17" name="age_range" value="0-17" <?php if (($formData['age_range'] ?? '') === '0-17') echo 'checked'; ?>> 0-17
        <input type="radio" id="18-30" name="age_range" value="18-30" <?php if (($formData['age_range'] ?? '') === '18-30') echo 'checked'; ?>> 18-30
        <input type="radio" id="30-50" name="age_range" value="30-50" <?php if (($formData['age_range'] ?? '') === '30-50') echo 'checked'; ?>> 30-50
        <input type="radio" id="50+" name="age_range" value="50+" <?php if (($formData['age_range'] ?? '') === '50+') echo 'checked'; ?>> 50+
    </div>

    <div class="mb-3">
        <label class="form-label">Select One or More Options:</label><br>
        <input type="checkbox" name="contact_options[]" value="newsletter" <?php if (isset($formData['contact_options']) && in_array('newsletter', (array)$formData['contact_options'])) echo 'checked'; ?>> Newsletter
        <input type="checkbox" name="contact_options[]" value="email" <?php if (isset($formData['contact_options']) && in_array('email', (array)$formData['contact_options'])) echo 'checked'; ?>> Email
        <input type="checkbox" name="contact_options[]" value="text" <?php if (isset($formData['contact_options']) && in_array('text', (array)$formData['contact_options'])) echo 'checked'; ?>> Text
    </div>

    <button type="submit" class="btn btn-primary">Add Contact</button>
</form>
