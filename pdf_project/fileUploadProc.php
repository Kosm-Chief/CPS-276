<?php
require_once 'Pdo_methods.php';

$output = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileName = trim($_POST['filename']);
    $pdfFile = $_FILES['pdf_file'];

    if ($pdfFile['type'] !== 'application/pdf') {
        $output = "<p style='color:red;'>File must be a PDF.</p>";
    }
    elseif ($pdfFile['size'] > 100000) {
        $output = "<p style='color:red;'>File is too large. Must be under 100KB.</p>";
    } else {
        $uploadPath = 'files/' . basename($pdfFile['name']);

        if (move_uploaded_file($pdfFile['tmp_name'], $uploadPath)) {
            $pdo = new PdoMethods();
            $sql = "INSERT INTO pdf_files (file_name, file_path) VALUES (:name, :path)";
            $bindings = [
                [':name', $fileName, 'str'],
                [':path', $uploadPath, 'str']
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $output = "<p style='color:red;'>Database error.</p>";
            } else {
                $output = "<p style='color:green;'>File uploaded successfully!</p>";
            }
        } else {
            $output = "<p style='color:red;'>Could not upload the file.</p>";
        }
    }
}
?>
