<?php
// pages/deleteContacts.php

// Check if user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['status'])) {
    header('Location: index.php?page=login');
    exit();
}

$pdo = new PdoMethods();
$message = "";

// If Delete button clicked
if (isset($_POST['delete'])) {
    if (isset($_POST['deleteIds'])) {
        $deleteIds = $_POST['deleteIds'];
        $error = false;

        foreach ($deleteIds as $id) {
            $sql = "DELETE FROM contacts WHERE id = :id";
            $bindings = [
                [':id', $id, 'int']
            ];
            $result = $pdo->otherBinded($sql, $bindings);
            if ($result === 'error') {
                $error = true;
            }
        }

        if ($error) {
            $message = "<p class='text-danger'>Could not delete the contacts</p>";
        } else {
            $message = "<p class='text-success'>Contact(s) deleted</p>";
        }
    }
}

$sql = "SELECT * FROM contacts";
$records = $pdo->selectNotBinded($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Delete Contact(s)</h2>
    <?php echo $message; ?>

    <?php if ($records == 'error' || count($records) == 0) { ?>
        <p>There are no records to display.</p>
    <?php } else { ?>
        <form method="post" action="index.php?page=deleteContacts">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Email</th>
                        <th>Delete?</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><?php echo htmlspecialchars($row['state']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><input type="checkbox" name="deleteIds[]" value="<?php echo $row['id']; ?>"></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="delete" class="btn btn-danger">Delete Selected</button>
        </form>
    <?php } ?>
</div>
</body>
</html>
