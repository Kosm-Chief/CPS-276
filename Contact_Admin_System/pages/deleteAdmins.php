<?php
// pages/deleteAdmins.php

// Only allow admins to access
if (!isset($_SESSION['name']) || !isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
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
            $sql = "DELETE FROM admins WHERE id = :id";
            $bindings = [
                [':id', $id, 'int']
            ];
            $result = $pdo->otherBinded($sql, $bindings);
            if ($result === 'error') {
                $error = true;
            }
        }

        if ($error) {
            $message = "<p class='text-danger'>Could not delete the admin(s)</p>";
        } else {
            $message = "<p class='text-success'>Admin(s) deleted</p>";
        }
    }
}

// Query all admins
$sql = "SELECT * FROM admins";
$records = $pdo->selectNotBinded($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Delete Admin(s)</h2>
    <?php echo $message; ?>

    <?php if ($records == 'error' || count($records) == 0) { ?>
        <p>There are no records to display.</p>
    <?php } else { ?>
        <form method="post" action="index.php?page=deleteAdmins">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Delete?</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
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
