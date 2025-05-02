<?php
require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';

function init() {
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

    // Get contacts list
    $db = new Db_conn();
    $pdo = $db->connect();
    $methods = new Pdo_methods();

    $sql = "SELECT * FROM contactMod ORDER BY lastName, firstName";
    $records = $methods->selectBinded($sql, []);

    // Generate table
    $contacts = '';
    if($records == 'error'){
        $contacts = '<p>There has been an error processing your request</p>';
    }
    else if(empty($records)){
        $contacts = '<p>No contacts found</p>';
    }
    else {
        $contacts = '<form method="post" action="controllers/deleteContactProc.php">';
        $contacts .= '<input type="submit" class="btn btn-danger mb-3" name="delete" value="Delete Selected Contacts">';
        $contacts .= '<table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Contact Method</th>
                            <th>Age</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($records as $row){
            $contacts .= '<tr>';
            $contacts .= '<td>' . htmlspecialchars($row['firstName'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['lastName'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['address'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['city'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['state'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['phone'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['email'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['dob'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['contacts'] ?? '') . '</td>';
            $contacts .= '<td>' . htmlspecialchars($row['age'] ?? '') . '</td>';
            $contacts .= '<td><input type="checkbox" name="chkbx[]" value="' . $row['id'] . '"></td>';
            $contacts .= '</tr>';
        }

        $contacts .= '</tbody></table></form>';
    }

    return <<<HTML
    {$nav}
    <div class="container">
        <h1>Delete Contact(s)</h1>
        {$message}
        {$contacts}
    </div>
HTML;
} 