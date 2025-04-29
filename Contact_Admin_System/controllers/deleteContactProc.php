<?php
require_once '../classes/Pdo_methods.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contactIds'])) {

    $pdo = new Pdo_methods();
    $db = $pdo->connect(); // Get database connection

    $placeholders = implode(',', array_fill(0, count($_POST['contactIds']), '?'));

    $sql = "DELETE FROM contacts WHERE id IN ($placeholders)";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($_POST['contactIds']);

        header("Location: ../index.php?page=deleteContacts&message=" . urlencode("Selected contacts deleted successfully."));
        exit();
    } catch (PDOException $e) {
        header("Location: ../index.php?page=deleteContacts&message=" . urlencode("Error deleting contacts: " . $e->getMessage()));
        exit();
    }

} else {
    header("Location: ../index.php?page=deleteContacts&message=" . urlencode("No contacts selected to delete."));
    exit();
}
?>
