<?php
require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';

function init() {
    $pdo = new Pdo_methods();

    // Get all admins
    $sql = "SELECT id, name, email, password, status FROM admins ORDER BY name";
    $records = $pdo->selectBinded($sql, []);

    // Get messages if any
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

    // Generate table rows
    $tableRows = '';
    if ($records != 'error' && !empty($records)) {
        foreach ($records as $row) {
            // Split name into first and last
            $nameParts = explode(' ', $row['name'], 2);
            $firstName = htmlspecialchars($nameParts[0] ?? '');
            $lastName = htmlspecialchars($nameParts[1] ?? '');
            
            $email = htmlspecialchars($row['email']);
            $password = htmlspecialchars($row['password']);
            $status = htmlspecialchars($row['status']);
            
            $tableRows .= <<<HTML
            <tr>
                <td>{$firstName}</td>
                <td>{$lastName}</td>
                <td>{$email}</td>
                <td>{$password}</td>
                <td>{$status}</td>
                <td><input type="checkbox" name="admin_ids[]" value="{$row['id']}"></td>
            </tr>
HTML;
        }
    }

    return <<<HTML
    {$nav}
    <div class="container">
        <h1>Delete Admin(s)</h1>
        {$message}
        <form action="controllers/deleteAdminProc.php" method="post">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    {$tableRows}
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger" name="delete">Delete Selected</button>
        </form>
    </div>
HTML;
}
?> 