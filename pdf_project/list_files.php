<?php echo "Using Db_conn from: " . __DIR__ . "/Db_conn.php<br>"; ?>
<?php require_once 'listFilesProc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white p-4 rounded shadow-sm">
            <h2 class="mb-4">List Files</h2>
            <a href="file_upload.php">Add File</a><br><br>

            <ul class="list-unstyled">
                <?php echo $output; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
