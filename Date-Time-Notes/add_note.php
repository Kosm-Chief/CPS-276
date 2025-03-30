<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$message = $dt->checkSubmit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Note</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4 border border-warning">
  <div class="container">
    <h2>Add Note</h2>
    <a href="display_notes.php">Display Notes</a>

    <?= $message ?? '' ?>

    <form method="post">
      <div class="mb-3">
        <label for="dateTime" class="form-label">Date and Time</label>
        <input type="datetime-local" class="form-control" name="dateTime" id="dateTime">
      </div>
      <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea name="note" id="note" class="form-control" rows="5"></textarea>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
</body>
</html>
