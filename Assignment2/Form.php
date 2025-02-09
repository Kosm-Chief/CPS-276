<?php
// Generating an array of numbers from 1 to 50
$numbers = range(1, 50);
$evenNumbersArray = [];

// Loop through the numbers and store only even ones
foreach ($numbers as $number) {
    if ($number % 2 == 0) {
        $evenNumbersArray[] = $number;
    }
}

// Convert the even numbers array into a formatted string
$evenNumbers = "Even Numbers: " . implode(" - ", $evenNumbersArray);

// Heredoc for form with Bootstrap styling
$form = <<<EOD
<form>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
        <label for="textarea" class="form-label">Example textarea</label>
        <textarea class="form-control" id="textarea" rows="3"></textarea>
    </div>
</form>
EOD;

// Function to create a table with Bootstrap styling
function createTable($rows, $columns) {
    $table = '<table class="table table-bordered text-center">';
    $table .= '<thead><tr>';
    for ($j = 1; $j <= $columns; $j++) {
        $table .= "<th>Col $j</th>";
    }
    $table .= '</tr></thead><tbody>';
    for ($i = 1; $i <= $rows; $i++) {
        $table .= '<tr>';
        for ($j = 1; $j <= $columns; $j++) {
            $table .= "<td>Row $i, Col $j</td>";
        }
        $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    return $table;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Webpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <p><?php echo $evenNumbers; ?></p>
    <?php
        echo $form;
        echo createTable(8, 6);
    ?>
</body>
</html>
