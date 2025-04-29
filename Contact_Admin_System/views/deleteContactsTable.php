<?php
require_once 'includes/security.php';
protectPage();

require_once 'classes/Pdo_methods.php';

$pdo = new Pdo_methods();

// Correct SQL for your contacts table
$sql = "SELECT id, fname, lname, email, phone FROM contacts"; 

$records = $pdo->selectBinded($sql, []);
?>

<h2>Delete Contact(s)</h2>

<?php
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
?>

<?php if ($records): ?>
<form method="post" action="controllers/deleteContactProc.php">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Select</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row): ?>
            <tr>
                <td><input type="checkbox" name="contactIds[]" value="<?php echo $row['id']; ?>"></td>
                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                <td><?php echo htmlspecialchars($row['lname']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-danger mt-3">Delete Selected Contacts</button>
</form>
<?php else: ?>
<p>No contacts found.</p>
<?php endif; ?>
