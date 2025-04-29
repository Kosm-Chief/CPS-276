<?php
require_once 'includes/security.php';
protectPage();

require_once 'classes/Pdo_methods.php';

$pdo = new Pdo_methods();

// Correct SQL for your admins table
$sql = "SELECT id, name, email, password, status FROM admins";

$records = $pdo->selectBinded($sql, []);
?>

<h2>Delete Admin(s)</h2>

<?php
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
?>

<?php if ($records): ?>
<form method="post" action="controllers/deleteAdminProc.php">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Status</th>
                <th>Select</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['password']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><input type="checkbox" name="adminIds[]" value="<?php echo $row['id']; ?>"></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-danger mt-3">Delete</button>
</form>
<?php else: ?>
<p>No admins found.</p>
<?php endif; ?>
