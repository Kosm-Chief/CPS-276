<?php
$output = "";
$acknowledgement = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/rest_client.php';
    $result = getWeather();
    $acknowledgement = $result[0];
    $output = $result[1] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Weather</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Enter Zip Code to Get City Weather</h1>

    <?php if ($acknowledgement): ?>
        <div class="alert alert-info"><?= $acknowledgement ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code:</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?= htmlspecialchars($_POST['zip_code'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?= $output ?>
</div>
</body>
</html>
