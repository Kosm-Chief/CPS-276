<?php
require_once('../classes/Pdo_methods.php');

$pdo = new PdoMethods();
$sql = "SELECT name FROM names ORDER BY name ASC";
$records = $pdo->selectNotBinded($sql);

if ($records === 'error') {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Could not retrieve names.']);
} elseif (empty($records)) {
    echo json_encode(['masterstatus' => 'success', 'msg' => 'No names found.', 'names' => '']);
} else {
    $output = "<ul class='list-group'>";
    foreach ($records as $row) {
        $output .= "<li class='list-group-item'>" . htmlspecialchars($row['name']) . "</li>";
    }
    $output .= "</ul>";
    echo json_encode(['masterstatus' => 'success', 'msg' => '', 'names' => $output]);
}

?>