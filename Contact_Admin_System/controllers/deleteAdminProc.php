<?php
require_once '../classes/Pdo_methods.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminIds'])) {

    $pdo = new Pdo_methods();
    $db = $pdo->connect(); // <<< Properly call connect() to get a usable PDO object

    // Create placeholders ?,?,?
    $placeholders = implode(',', array_fill(0, count($_POST['adminIds']), '?'));

    $sql = "DELETE FROM admins WHERE id IN ($placeholders)";

    try {
        $stmt = $db->prepare($sql); // <<< use $db, NOT $pdo->pdo
        $stmt->execute($_POST['adminIds']);
        
        header("Location: ../index.php?page=deleteAdmins&message=" . urlencode("Selected admins deleted successfully."));
        exit();
    } catch (PDOException $e) {
        header("Location: ../index.php?page=deleteAdmins&message=" . urlencode("Error deleting admins: " . $e->getMessage()));
        exit();
    }

} else {
    header("Location: ../index.php?page=deleteAdmins&message=" . urlencode("No admins selected to delete."));
    exit();
}
?>
