<?php
require_once 'Pdo_methods.php';

$pdo = new PdoMethods();
$sql = "SELECT file_name, file_path FROM pdf_files";
$records = $pdo->selectNotBinded($sql);

$output = '';

if ($records == 'error') {
    $output = "<p style='color:red;'>Database error.</p>";
} elseif (count($records) == 0) {
    $output = "<p>No files found.</p>";
} else {
    foreach ($records as $row) {
        $output .= "<li><a target='_blank' href='{$row['file_path']}'>" . htmlspecialchars($row['file_name']) . "</a></li>";
    }
}
?>
