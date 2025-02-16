<?php require_once 'processNames.php';
$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Name List</h2>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="nameInput" placeholder="Enter First and Last Name">
            </div>
            <button type="submit" name="addName" class="btn btn-primary">Add Name</button>
            <button type="submit" name="clearNames" class="btn btn-danger">Clear Names</button>
        </form>
        <h3 class="mt-3">Sorted Names</h3>
        <textarea style="height: 500px;" class="form-control"
        id="namelist" name="namelist"><?php echo $output ?></textarea>
    </div>
</body>
</html>
