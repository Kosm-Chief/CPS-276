<?php
function init() {
    // Get sticky form data if it exists
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']); // Clear the form data from session after retrieving

    // Add error/success message display
    $message = '';
    if (isset($_SESSION['error'])) {
        $message = "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    } elseif (isset($_SESSION['success'])) {
        $message = "<div class='alert alert-success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }

    // Navigation bar based on user status
    $nav = '';
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

    // Helper function to get old form value
    $old = function($field) use ($formData) {
        // Default test values if no form data exists
        $defaults = [
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => 'password123',
            'status' => 'staff'
        ];
        return htmlspecialchars($formData[$field] ?? $defaults[$field] ?? '');
    };

    // Get the selected status
    $selectedStatus = $old('status');
    $adminSelected = $selectedStatus === 'admin' ? 'selected' : '';
    $staffSelected = $selectedStatus === 'staff' ? 'selected' : '';

    return <<<HTML
    {$nav}
    <div class="container">
        <h1>Add Admin</h1>
        {$message}
        <form action="controllers/addAdminProc.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{$old('name')}" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{$old('email')}" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Please Select a Status</option>
                    <option value="admin" {$adminSelected}>Admin</option>
                    <option value="staff" {$staffSelected}>Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Admin</button>
        </form>
    </div>
HTML;
}
?> 