<?php require_once 'fileUploadProc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white p-4 rounded shadow-sm">
            <h2 class="mb-4">File Upload</h2>
            <a href="list_files.php">Show File List</a><br><br>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">File Name</label>
                    <input type="text" name="filename" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Choose PDF File</label>
                    <input type="file" name="pdf_file" class="form-control" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Upload File</button>
            </form>

            <div class="mt-3">
                <?php echo $output; ?>
            </div>
        </
