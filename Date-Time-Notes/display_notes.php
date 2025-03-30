<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$table = $dt->getNotes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Display Notes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4 border border-warning">
  <div class="container">
    <h2>Display Notes</h2>
    <a href="add_note.php">Add Note</a>

    <?= $table ?? '' ?>

    <form method="post">
      <div class="mb-3">
        <label for="begDate">Beginning Date</label>
        <input type="date" name="begDate" id="begDate" class="form-control">
      </div>
      <div class="mb-3">
        <label for="endDate">Ending Date</label>
        <input type="date" name="endDate" id="endDate" class="form-control">
      </div>
      <button type="submit" name="getNotes" class="btn btn-primary">Get Notes</button>
    </form>
  </div>
</body>
</html>
