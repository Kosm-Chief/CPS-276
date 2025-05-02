<?php
// Remove the require since we'll handle form processing in addContactProc.php
// require_once 'controllers/addContact.php';

function init(){
    // Get sticky form data if it exists
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']); // Clear the form data from session after retrieving
    
    // Define states array
    $states = ['MI', 'OH', 'IN', 'IL', 'WI'];
    
    if ($_SESSION['user']['status'] == 'admin') {
        $nav = <<<HTML
        <nav class="nav mb-3">
            <a href="index.php?page=addContact" class="nav-link">Add Contact</a>
            <a href="index.php?page=deleteContacts" class="nav-link">Delete Contact(s)</a>
            <a href="index.php?page=addAdmin" class="nav-link">Add Admin</a>
            <a href="index.php?page=deleteAdmins" class="nav-link">Delete Admin(s)</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </nav>
HTML;
    } else {
        $nav = <<<HTML
        <nav class="nav mb-3">
            <a href="index.php?page=addContact" class="nav-link">Add Contact</a>
            <a href="index.php?page=deleteContacts" class="nav-link">Delete Contact(s)</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </nav>
HTML;
    }

    // Add error/success message display
    $message = '';
    if (isset($_SESSION['error'])) {
        $message = "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    } elseif (isset($_SESSION['success'])) {
        $message = "<div class='alert alert-success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }

    // Helper function to get old form value
    $old = function($field) use ($formData) {
        // Default test values if no form data exists
        $defaults = [
            'fname' => 'John',
            'lname' => 'Doe',
            'address' => '123 Main St',
            'city' => 'Detroit',
            'state' => 'MI',
            'zip' => '48201',
            'phone' => '313.555.1234',
            'email' => 'john.doe@example.com',
            'dob' => '01/15/1985',
            'age' => '30-50',
            'contacts' => ['Newsletter', 'Email Updates']
        ];
        return htmlspecialchars($formData[$field] ?? $defaults[$field] ?? '');
    };

    // Helper function to check if a radio button was selected
    $isChecked = function($field, $value) use ($formData) {
        return isset($formData[$field]) && $formData[$field] === $value ? 'checked' : '';
    };

    // Helper function to check if a checkbox was selected
    $isSelected = function($value) use ($formData) {
        return isset($formData['contacts']) && in_array($value, $formData['contacts']) ? 'checked' : '';
    };

    // Build state options
    $stateOptions = '';
    foreach ($states as $state) {
        $selected = ($old('state') === $state || (!$old('state') && $state === 'MI')) ? 'selected' : '';
        $stateOptions .= "<option value=\"{$state}\" {$selected}>{$state}</option>";
    }

    return <<<HTML
    {$nav}
    <div class="container">
        <h1>Add Contact</h1>
        {$message}
        <form method="post" action="controllers/addContactProc.php">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" value="{$old('fname')}" required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{$old('address')}" required>
                    </div>
                    <div class="mb-3">
                        <label>City</label>
                        <input type="text" class="form-control" name="city" value="{$old('city')}" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{$old('phone')}" placeholder="999.999.9999" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" value="{$old('lname')}" required>
                    </div>
                    <div class="mb-3">
                        <label>State</label>
                        <select class="form-control" name="state" required>
                            {$stateOptions}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" name="zip" value="{$old('zip')}" placeholder="12345 or 12345-6789" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{$old('email')}" required>
                    </div>
                    <div class="mb-3">
                        <label>Date of Birth</label>
                        <input type="text" class="form-control" name="dob" value="{$old('dob')}" placeholder="mm/dd/yyyy" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label>Choose an Age Range</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="age" value="0-17" {$isChecked('age', '0-17')} required>
                        <label class="form-check-label">0-17</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="age" value="18-30" {$isChecked('age', '18-30')}>
                        <label class="form-check-label">18-30</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="age" value="30-50" {$isChecked('age', '30-50')}>
                        <label class="form-check-label">30-50</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="age" value="50+" {$isChecked('age', '50+')}>
                        <label class="form-check-label">50+</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label>Select One or More Options</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="contacts[]" value="Newsletter" {$isSelected('Newsletter')}>
                        <label class="form-check-label">Newsletter</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="contacts[]" value="Email Updates" {$isSelected('Email Updates')}>
                        <label class="form-check-label">Email Updates</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="contacts[]" value="Text Updates" {$isSelected('Text Updates')}>
                        <label class="form-check-label">Text Updates</label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Contact</button>
        </form>
    </div>
HTML;
}

?> 