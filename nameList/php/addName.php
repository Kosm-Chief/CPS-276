<?php
require_once('../classes/Pdo_methods.php');

// Read raw JSON body
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name'])) {
    $fullName = trim($data['name']);
    $parts = explode(" ", $fullName);

    if (count($parts) === 2) {
        $first = ucfirst(strtolower($parts[0]));
        $last = ucfirst(strtolower($parts[1]));
        $formatted = "$last, $first";

        $pdo = new PdoMethods();
        $sql = "INSERT INTO names (name) VALUES (:name)";
        $bindings = [ [':name', $formatted, 'str'] ];
        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'error') {
            echo json_encode(['masterstatus' => 'error', 'msg' => 'Insert failed.']);
        } else {
            echo json_encode(['masterstatus' => 'success', 'msg' => 'Name added.']);
        }
    } else {
        echo json_encode(['masterstatus' => 'error', 'msg' => 'Please enter exactly two names.']);
    }
} else {
    echo json_encode(['masterstatus' => 'error', 'msg' => 'Name not received.']);
}


?>