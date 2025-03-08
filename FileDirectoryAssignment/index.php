<?php
require_once "classes/Directories.php"; // Include the Directories class

$directoryPath = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dirName = trim($_POST["directoryName"]);
    $fileContent = trim($_POST["fileContent"]);

    if (preg_match("/^[a-zA-Z0-9]+$/", $dirName)) { // Allow alphanumeric characters only
        $directories = new Directories();
        $result = $directories->createDirectory($dirName, $fileContent);
        
        if ($result["success"]) {
            $directoryPath = "directories/$dirName/readme.txt";
            $message = "File and directory were created";
        } else {
            $message = $result["message"];
        }
    } else {
        $message = "Invalid directory name. Only alphanumeric characters are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File and Directory Assignment</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { font-size: 24px; }
        p { font-size: 16px; }
        a { color: blue; text-decoration: underline; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { background-color: #6366F1; color: white; padding: 8px 16px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>File and Directory Assignment</h2>
    <p>Enter a folder name and the contents of a file. Folder names should contain alphanumeric characters only.</p>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($directoryPath)): ?>
        <p><a href="<?= htmlspecialchars($directoryPath); ?>" target="_blank">Path where file is located</a></p>
    <?php endif; ?>

    <form method="post">
        <label for="directoryName">Folder Name:</label>
        <input type="text" name="directoryName" id="directoryName" required>
        <br><br>

        <label for="fileContent">File Content:</label>
        <textarea name="fileContent" id="fileContent" required></textarea>
        <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
